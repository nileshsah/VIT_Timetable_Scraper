PHP script to scrape student timetable from Parent Login ( via cURL )

# Usage
Initiate a session by passing a randomly generated string as 'id' tag to getCaptcha.php via a GET request. 
e.g .../getCaptcha.php?id=7xfFM
This returns a jpg format image of the captcha.

Now pass in the variables,
hash: Same as the 'id' above used to initiate a session
reg: Registration Number
dd: Date of Birth
m: Parent Mobile Number
cap: Captcha Text

To the getCaptcha.php script again via GET request to initiate login and timetable scraping.




