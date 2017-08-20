# MsgWebService with Laravel PHP Framework and MySQL Database

This application and web service are used to manage and attend requests for short messages in multiple languages. 
## AUTOR 
Micha Meier

## Features
<ul>
 <li>Get one or more messages </li>
<li>Replacement inside messages</li>
<li>Multi language support</li>
<li>Multi application support with access token</li>
<li>Responsive Interface to manage messages</li>
<li>Detailed error messages on failure</li>
</ul>

## Instructions
 
 ### Web Service
 Basic Json request: \<your domain\>/{"appid":\<appid\>,"apptoken":"\<token\>","modulid":\<modul id\>,"applang":"\<app language shortform\>","requitems":\<array of message ids\>,"requitemsreplace":\<array for replacement  or empty\>}
 
 ### Message CRUD
 Create your signup and login on \<your domain\>/message
 New apps and modules are created direct in the database, future managing with an interface is planned. 
 Example for replacement inside a message: This is a test [[0]] replace [[1]] message

## Example usage
Get one message <br>{"appid":1,"apptoken":"msgwsiscool!","modulid":1,"applang":"pt","requitems":[1],"requitemsreplace":[]}<br><br>
Get multiples messges <br>{"appid":1,"apptoken":"msgwsiscool!","modulid":1,"applang":"pt","requitems":[1,2,3],"requitemsreplace":[[],[],[]]} <br><br>
Replace inside messages<br>{"appid":1,"apptoken":"msgwsiscool!","modulid":1,"applang":"pt","requitems":[1,2,43],"requitemsreplace":[[],[],["test1", "test2"]]} <br><br>
Incomplete request <br>{"appid":1,"appoken":"msgwsiscool!","modulid":1,"applng":"pt","requitems":[1,2,3],"requitemsreplace":[[],[],[]]}
