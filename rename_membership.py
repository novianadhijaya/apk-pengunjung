
import re

input_path = '/opt/lampp/htdocs/app_pengunjung/visits_import.sql'
output_path = '/opt/lampp/htdocs/app_pengunjung/visits_import_renamed.sql'

print(f"Processing {input_path}...")

with open(input_path, 'r', encoding='utf-8') as f_in, open(output_path, 'w', encoding='utf-8') as f_out:
    for line in f_in:
        # Look for INSERT VALUES line
        # ('005', 'Name', 'Type', ...
        # Regex to capture membership_type (3rd field)
        # We need to be careful about not breaking the SQL structure.
        # Format: ('member_id', 'visitor_name', 'membership_type', ...
        
        # We can try to replace strictly based on the known format structure if possible, 
        # or just string replacement if unique enough.
        # 'NON-MEMBER' is unique enough? 
        # But "Execpt NON-MEMBER -> Member" is harder with simple replace.
        
        # Let's use regex to find the tuple.
        # This regex matches the start of a tuple value
        # \('([^']*)', '([^']*)', '([^']*)',
        
        def replace_type(match):
            m_id = match.group(1)
            m_name = match.group(2)
            m_type = match.group(3)
            
            new_type = 'Member'
            if m_type.upper() == 'NON-MEMBER':
                new_type = 'Umum'
            
            # Reconstruct the start of the tuple
            return f"('{m_id}', '{m_name}', '{new_type}',"

        # Regex explanation:
        # \('       -> Match literal ('
        # ([^']*)   -> Group 1: member_id (anything but quote)
        # ', '      -> Match separator
        # ([^']*)   -> Group 2: visitor_name
        # ', '      -> Match separator
        # ([^']*)   -> Group 3: membership_type
        # ',        -> Match separator to next field
        
        new_line = re.sub(r"\('([^']*)', '([^']*)', '([^']*)',", replace_type, line)
        f_out.write(new_line)

print(f"Finished. Output saved to {output_path}")
print("Please manually rename/overwrite if satisfied.")
