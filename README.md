# ford
Ford Connect API Hackathon entry

# Inspiration
My son is about to turn twelve and will be taking borrowing my car in a few years, so a tool such as this would definitely keep my mind a little more at ease when he's out.

# What it does
Curphew lets the user set a curfew for their Ford vehicle and once the curfew time arrives, checks every half hour (once it's in the curfew window) if the vehicle is located within the specified radius of the user's home. If it's not, it sends out either an email or an SMS message (or both) to the user and if specified, to a secondary person as well (in this case, my kid!).  Once the vehicle is in its proper place, it sends out another email or SMS (or both) stating that that vehicle has arrived.

# How I built it
I build it using the Ford Connect API and PHP, with a MySQL database to keep track of the user's information.

# Challenges I ran into
The Ford Connect API was a breeze to implement. The real challenge was getting the responsive layout working correctly on multiple screen sizes.

# Accomplishments that I'm proud of
The fact that I was able to send out both emails and SMS messages when the vehicle is not in its proper place, since text messages are definitely more apt to be read than email messages.

# What I learned
That I should definitely get a new Ford!  The fact that a programmer can interface with a vehicle's API and obtain specific info opens the door to hundreds of potential apps.  If I can scrape up some time, I would like to make a second Ford Connect app.

# What's next for Curphew
Getting this project integrated into the Ford app would be awesome (and it shouldn't really be difficult to implement).  Different timezones would be a plus (right now it defaults to EST).  Multiple curfews (while avoiding overlapping) would be a neat feature.
