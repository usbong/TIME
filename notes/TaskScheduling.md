# NOTES: Task Scheduling

## LINUX MACHINE (LUBUNTU 20.04)

### Steps to set a TASK with CRON COMMAND 

1) Enter the following COMMAND on TERMINAL

> sudo crontab -e

2) Add the following example TASK to the schedule 

> 41 15 * * * /opt/lampp/htdocs/usbong_time/kasangkapan/add-on software/generatePuzzleForTheDay.sh

where: @41:15 (HH:MM), daily, execute: `generatePuzzleForTheDay.sh`

Done!

#### Reminder

1) CHANGED file via `sudo crontab -e`, with keyphrase `sudo`<br/> 
--> a variation to `crontab -e`, without the `sudo`

### Additional Notes

1) Verify CRON status by entering the following COMMAND on TERMINAL

> systemctl status cron

#### Example OUTPUT:

> Dec 20 15:41:01 USBONG-MACHINE CRON[3951]: (root) CMD (/opt/lampp/htdocs/usbong_time/kasangkapan/"add-on software"/generatePuzzleForTheDay.sh)


