# mikrotik-graph
Open source project showing Mikrotik internet usage graphically.


## How to work? 
### Server.php - Server Side
First, it connects to the Mikrotik device via API with the information written in the Config.php file.
Afterwards, the rx/tx information of the interfaces written in a settings file at the time written in the settings file is connected to the file-based database.

