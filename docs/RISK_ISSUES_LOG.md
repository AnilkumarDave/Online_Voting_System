# Risk & Issues Log 

| ID  | Risk / Issue                          | Impact                                  | Mitigation                                         | Owner     | Status |
|-----|--------------------------------------|----------------------------------------|---------------------------------------------------|----------|--------|
| R1  | SQL Injection on login or vote forms  | Data breach, vote manipulation         | Use prepared statements; validate inputs         | Developer | Open   |
| R2  | Session hijacking                     | Unauthorized access to admin or voter accounts | Use session_regenerate_id(), HTTPS, session timeout | Developer | Open   |
| R3  | Database table corruption             | Loss of votes or candidate data        | Regular backups; test scripts before updates     | Developer | Closed |
| R4  | Admin credentials compromise          | Full control of system                  | Strong password; limit admin login attempts      | Developer | Open   |
| R5  | Incorrect vote tally                  | Wrong election results                  | Test vote scenarios; verify counting logic       | Developer | Closed |
| R6  | Data privacy violation                | Exposure of voter info                  | Mask sensitive info; do not store plain passwords | Developer | Open   |
| R7  | Server downtime during voting         | Voting disruption                        | Host on reliable server; monitor uptime          | Developer | Open   |
