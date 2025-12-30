
import csv
import re

csv_path = '/opt/lampp/htdocs/app_pengunjung/visitor_list.xlsx - Worksheet.csv'
sql_path = '/opt/lampp/htdocs/app_pengunjung/visits_import.sql'
sql_out_path = '/opt/lampp/htdocs/app_pengunjung/visits_import_synced.sql'

# 1. Read CSV Data to build a lookup map
# Map Key: (visitor_name_lowercase, visit_date, visit_time) -> room_name
csv_data = {}
print("Reading CSV...")
with open(csv_path, 'r', encoding='utf-8') as f:
    reader = csv.reader(f)
    header = next(reader) # Skip header
    # Header: ID Anggota, Nama Pengunjung, Tipe Keanggotaan, Institusi, Nama Ruangan, Tanggal Kunjungan
    # Indices: 0, 1, 2, 3, 4, 5
    for row in reader:
        if len(row) < 6: continue
        name = row[1].strip().lower()
        room = row[4].strip()
        timestamp = row[5].strip()
        
        if not room: continue # Skip if room is empty in CSV too
        
        # Split timestamp into date and time if possible
        parts = timestamp.split(' ')
        if len(parts) >= 2:
            date_part = parts[0]
            time_part = parts[1]
            key = (name, date_part, time_part)
            csv_data[key] = room

print(f"Loaded {len(csv_data)} entries with room names from CSV.")

# 2. Process SQL file
print("Processing SQL...")
updated_count = 0
with open(sql_path, 'r', encoding='utf-8') as f_in, open(sql_out_path, 'w', encoding='utf-8') as f_out:
    for line in f_in:
        # Regex to parse INSERT VALUES
        # Example: ('', 'achmad yani', 'NON-MEMBER', 'BKD DPR RI', '', '2018-01-04', '13:03:43', '2018-01-04 13:03:43', NULL),
        # We look for lines starting with ('', 
        if line.strip().startswith("('',"):
            # A naive split by comma is dangerous because of commas in data.
            # But here the structure is relatively simple. 
            # We can try to extract the fields using a regex or simple string manipulation if format is consistent.
            # Given the file format viewed earlier, fields are quoted with '
            
            # Let's use a robust regex to capture the groups
            # 1: id (empty), 2: name, 3: type, 4: inst, 5: room, 6: date, 7: time, 8: created, 9: updated
            match = re.match(r"\s*\('', '([^']*)', '([^']*)', '([^']*)', '([^']*)', '([^']*)', '([^']*)',", line)
            if match:
                current_name = match.group(1)
                current_room = match.group(4)
                current_date = match.group(5)
                current_time = match.group(6)
                
                name_key = current_name.strip().lower()
                
                if current_room == '':
                    key = (name_key, current_date, current_time)
                    if key in csv_data:
                        new_room = csv_data[key]
                        # Replace the empty room '' with 'new_room'
                        # We reconstruct the line carefully
                        # Original part: 'BKD DPR RI', '', '2018-
                        # We want:       'BKD DPR RI', 'NEW ROOM', '2018-
                        
                        # Find the empty room field in the line. 
                        # It is the 5th field.
                        # Since we used regex to find it, let's substitute only the first occurrence of that sequence to be safe?
                        # No, simpler: we know exact context from regex match.
                        
                        # We can perform a substitution on the specific part of the string
                        # The match.group(4) is the room_name (which is empty string content, so regex captured nothing inside quotes)
                        # Actually group 4 corresponds to room_name based on my regex index counting? 
                        # visitor_name=1, membership=2, institution=3, room=4. Correct.
                        
                        # Wait, group 4 is room. match.group(4) is content.
                        # So we look for replacement of ` 'inst', '', 'date'` -> ` 'inst', 'New Room', 'date'`
                        
                        search_pattern = f"', '', '{current_date}'"
                        replacement = f"', '{new_room}', '{current_date}'"
                        
                        if search_pattern in line:
                            line = line.replace(search_pattern, replacement, 1)
                            updated_count += 1
            
        f_out.write(line)

print(f"Sync complete. Updated {updated_count} rows.")
