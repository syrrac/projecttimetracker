var mysql = require('mysql');
var util = require('util');
var AWS = require('aws-sdk');

var connection = mysql.createConnection({ //newly inserted
    host: "ls-77e1472d76ad627554447c61511cf31b8998c2ce.c1ca77nowf79.us-west-2.rds.amazonaws.com",
    user: "dbmasteruser",
    password: "comp4900",
    database: "database1",
});

var S = new AWS.S3({
    maxRetries: 0,
    region: 'us-west-2',
});

exports.handler = function(event, context, callback) { //entry point
    // Read options from the event.
    console.log("Reading options from event:\n", util.inspect(event, {depth: 5}));
    var srcBucket = event.Records[0].s3.bucket.name;
    var srcKey    = event.Records[0].s3.object.key;

    console.log("srcBucket: ", srcBucket);
    console.log("srcKey:    ", srcKey);


    // don't run on anything that isn't a CSV
    if (srcKey.match(/\.csv$/) === null) {
        var msg = "Key " + srcKey + " is not a csv file, bailing out";
        console.log(msg); //goes to cloudwatch
        return callback(null, {message: msg});
    }
        S.getObject({
        Bucket: srcBucket,
        Key: srcKey,
    }, function (err, data) {
        if (err !== null) { return callback(err, null); }
        console.log("Raw CSV data: " + data.Body.toString('utf-8'));
        
        
        //testing below
         var lines = data.Body.toString('utf-8').split('\n');
         lines.slice(1).forEach(function (raw_line) { 
            var line = raw_line.split(',');
            
            
            
            
            console.log(line);
            console.log(line[0]); //for testing
            
            
        

   
        //inserts projects into the database
        for (var i = 0; i < line.length; i++){
            var projectData = {Project_Name: line[5], Project_Desc: line[6], Project_Start_Date: line[7],
            Project_End_Date: line[8], Active: 1, Manager_User_ID: 1 };
        
                    
            connection.query('INSERT IGNORE INTO Project SET ?', projectData , function (error, results, fields) { 
                if (error) {
                    throw error;
                } else {
                    // connected!
                    console.log(results);
                    callback(error, results);
                }
                
            });
            
            break;
            
            }

            

            //grabs the Project_ID from the Project table and creates a row with it in the Users table
            for (var i = 0; i < line.length; i++) {
                var someVar = 0;
                connection.query('SELECT Project_ID FROM Project WHERE Project_Name = ' + mysql.escape(line[5]), function(error, results, fields) {

                    if(error) {
                        throw error;
                    } else {
                        setValue(results[0].Project_ID); 
                    }

                    function setValue(value){
                        someVar = value;
                        console.log(someVar);
                    }


                    var userData = {User_First_Name: line[1], User_Last_Name: line[0], User_Email: line[2], Active: 1,
                        User_Type_User_Type_ID: line[4], Project_Project_ID: (someVar), Password: line[3] };
        
                            
                    connection.query('INSERT IGNORE INTO User SET ?', userData , function (error, results, fields) { 
                        if (error) {
                            throw error;
                        } else {
                            // connected!
                            console.log(results);
                            callback(error, results);
                        }
                        
                        
                        connection.query('UPDATE Project, User SET Project.Manager_User_ID = User.User_ID WHERE Project.Project_ID = User.Project_Project_ID AND User.User_Type_User_Type_ID = 2', function (error, results, fields) {
                            if (error) {
                                throw error;
                            } else {
                                console.log(results);
                            }
                        });


                    });

                                        
                });


                break; 
            }


        });


        return callback(null, data);
        
    });




    
};

