
UPDATE visits SET membership_type = 'Member' WHERE membership_type != 'NON-MEMBER' AND membership_type != 'Umum';
UPDATE visits SET membership_type = 'Umum' WHERE membership_type = 'NON-MEMBER';
