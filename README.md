# Mad City RPG application

Mad City is a tabletop RPG game.

I am developing the mechanics and building an app to help the players.

I am starting with PHP and jQuery during the prototype phase. I will be transitioning to React once I know how I want the mechanics / application to operate.

I will also be setting this up as a PWA so that it can be played without an internet connection and loaded from the home screen.


#Start Up
run `npm install` to install all the required node packages
run `php composer.phar install` to install the PHP libraries


#Libraries Used
Google API Client  ( https://github.com/googleapis/google-api-php-client )
Ratchet Web Socket  ( http://socketo.me/ )
PHPMailer ( https://github.com/PHPMailer/PHPMailer )


#Start Chat Server
In order to start up the Chat server you will need to run `php chat/chat-server.php` in the root directory. This will begin the IO server to capture and send messages to all chat boards. Current limit of 1024 users per server.


#Gulp Workflow
Navigate to the *gulp* folder and run `gulp watch`. This will automatically build your SCSS and JS files into dev.js and live.js files


#Service Worker
We do have a service worker running on this application, although it can probably be removed until we move to React. If you run into any weird caching issues it might be the fault of the service worker.


**Development Path:**

### Phase 1 - Initial Development and Planning
Develop and Test Basic Mechanics (Current Phase)
Design the application.
Generally hack and prototype until we think we have found the soul of the application

### Phase 2 - React Conversion
Convert to React
? Convert to Socket.io / node for chat server
POSSIBLY convert to Firebase for database.
? Connect with Google / Facebook

### Phase 3 - PWA
Setup PWA: Service Workers, Local Storage, Working with No internet, Syncing with database when connection returns.
	
### Phase 4 - Polish
Add favorite feature creep features.
Roll mechanic to allow users to make any roll by clicking an icon next to that stat/skill/power

### Phase 5 ( The Distant Future ) - ??
Add D&D srd 5e ruleset and character sheets.
Potentially other rpgs.
Transition to more of a platform for any game. Similar to Roll20.net