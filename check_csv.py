
import csv

csv_path = '/opt/lampp/htdocs/app_pengunjung/visitor_list.xlsx - Worksheet.csv'

print("Scanning CSV for non-empty room names (index 4)...")
count = 0
with open(csv_path, 'r', encoding='utf-8') as f:
    reader = csv.reader(f)
    header = next(reader)
    print(f"Header: {header}")
    
    for i, row in enumerate(reader):
        if len(row) > 4:
            room = row[4].strip()
            if room:
                print(f"Row {i+2}: {row}")
                count += 1
                if count > 5: break
                
print(f"Found {count} rows with room data.")
