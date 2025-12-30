
import re

sql_path = '/opt/lampp/htdocs/app_pengunjung/visits_import.sql'
out_path = '/opt/lampp/htdocs/app_pengunjung/members_import.sql'

# Set to track processed member IDs to avoid duplicates
processed_ids = set()
members_to_insert = []

print("Reading visits_import.sql...")

with open(sql_path, 'r', encoding='utf-8') as f:
    for line in f:
        # Regex to parse INSERT VALUES
        # ('005', 'Fakhris Lutfianto Hapsoro, S.H', 'Standard', 'MPR', '', '2023-10-18', ...
        # Groups: 1=id, 2=name, 3=type, 4=inst
        match = re.match(r"\s*\('([^']*)', '([^']*)', '([^']*)', '([^']*)',", line)
        if match:
            m_id = match.group(1).strip()
            m_name = match.group(2).strip()
            m_type = match.group(3).strip()
            m_inst = match.group(4).strip()
            
            # Filter logic:
            if not m_id: continue
            if m_id.upper() == 'NON-MEMBER' or m_id.upper() == 'UMUM': continue
            if m_type.upper() == 'NON-ANGGOTA' or m_type.upper() == 'UMUM': continue
            if m_id == '-': continue

            # Strip non-digits from kode_anggota
            m_id_clean = re.sub(r'\D', '', m_id)
            if not m_id_clean: continue # Skip if no digits left

            if m_id_clean not in processed_ids:
                processed_ids.add(m_id_clean)
                members_to_insert.append({
                    'kode': m_id_clean,
                    'nama': m_name,
                    'inst': m_inst
                })

print(f"Found {len(members_to_insert)} unique members.")

# Generate SQL
# Schema: id_anggota, kode_anggota, nama_anggota, institusi, created_at
start_id = 2

with open(out_path, 'w', encoding='utf-8') as f:
    f.write("INSERT INTO `tbl_anggota` (`id_anggota`, `kode_anggota`, `nama_anggota`, `institusi`, `created_at`) VALUES\n")
    
    values_list = []
    for i, mem in enumerate(members_to_insert):
        curr_id = start_id + i
        # Escape quotes in strings
        name = mem['nama'].replace("'", "''")
        inst = mem['inst'].replace("'", "''")
        kode = mem['kode']
        
        val = f"({curr_id}, '{kode}', '{name}', '{inst}', NOW())"
        values_list.append(val)
    
    f.write(",\n".join(values_list))
    f.write(";\n")

print(f"Generated {out_path} with {len(values_list)} inserts.")
