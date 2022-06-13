This is the web application folder, that contains all needed to you execute the project inside Docker without isntallig nothing but Docker to set up and run all automaticaly.

To install Docker into your machine see more to Windows Operating System: https://docs.docker.com/desktop/windows/install/

or to Linux: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04

or even WSL (Linux on top of Windows): https://niwakatech.info/en/setting-up-docker-and-docker-compose-on-wsl2/


After installation, only open your terminal or command line and set to your folder using 'cd' command and in run the following command: docker-compose up --build
                           in Linux you may need to use 'sudo': sudo docker-compose up --build

In error case, you must to delete the folder 'dbdata' inside of '.docker' folder in the project, and so go to back in the project root folder and run 'sudo docker-compose up --build' or 'docker-compose up --build' according your operating system.
Seeing all green in terminal, access your browser and type: localhost:8000/ and then you can see the website.


---------------------------------------------------------------------------------------------------------------
For Designers (Frontend):

To change design of the webpages, sucha as CSS, HTML and so on related to FrontEnd only, you must to access the folder 'resources>views>' to find the all css and page files.

*** You can't to rename the files, their names is very important to application works, name such as 'home.blade.' or '.blade.' and extension '*.php', never must be changed.