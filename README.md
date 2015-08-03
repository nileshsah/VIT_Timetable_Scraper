PHP script to scrape student timetable from Parent Login ( via cURL )

# Usage
Initiate a session by passing a randomly generated string as 'id' tag to getCaptcha.php via a GET request. <br />
e.g .../getCaptcha.php?id=7xfFM <br />
This returns a jpg format image of the captcha. <br />

Now pass in the variables, <br />
hash: Same as the 'id' above used to initiate a session <br />
reg: Registration Number <br />
dd: Date of Birth <br />
m: Parent Mobile Number <br />
cap: Captcha Text <br />

To the getCaptcha.php script again via GET request to initiate login and timetable scraping. <br />
e.g .../getCaptcha.php?hash=7xfFM&reg=13BCE0864&dd=27101994&m=9629342354&cap=QG7L25




