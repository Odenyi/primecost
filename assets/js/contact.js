$(document).ready(function() {
   
// contact
    $("#contactbtn").click(function(e) {
        
        e.preventDefault()
        let name = $("#name").val();
        let  email = $("#mail").val();
        let message = $("#message").val();
        if(isnotvalidatefrm(name, email, message )){
            return;
        }
        displaySuccessMessage("Submitting request...",3000)
        
        $.ajax({
            type: "POST",
            url: "../php/mailer.php",
            data: {
                name: name,
                email: email, 
                message:message,
            },
            success: function(response) {
                
                if (response == 1){

           
                    // Clear input fields
                    $("#name").val('');
                    $("#mail").val('');
                    $("#message").val('');
                    
                    displaySuccessMessage("Hi " +name+ ", we have received your request and I will Contact you. Thank you")

                    
                }

                else{
                    displayErrorMessage("The was an error while submitting your data "+response,30000)
                }
            }
        });
    });

   
   function isnotvalidatefrm(name, email, message ){
    let isempty = true
    if(!name){
        displayErrorMessage("Please enter your name ")
        
        
        return isempty;

    }
    else if (!email) {
        displayErrorMessage("Please enter your Email ")

        return isempty;
        
    } 
   
    else {
        
        if (!isValidEmail(email)){
            displayErrorMessage("Please enter a valid Email ")
            return isempty
        }
        
        
      
        isempty = false;
        return isempty;
        
    }

   }

// Function to validate email using a regular expression
function isValidEmail(email) {
    var emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
    return emailRegex.test(email);
}

function isValidPhoneNumber(phoneNumber) {
    // Remove any spaces or non-digit characters
    phoneNumber = phoneNumber.replace(/\D/g, '');

    // Check if the phone number starts with "254," "+254," or "0"
    if (phoneNumber.startsWith("254")) {
        if (phoneNumber.length >= 12 && phoneNumber.length < 13) {
            return true;
        }
    } else if (phoneNumber.startsWith("+254")) {
        if (phoneNumber.length >= 13 && phoneNumber.length < 14) {
            return true;
        }
    } else if (phoneNumber.startsWith("0") && phoneNumber.length >= 10 && phoneNumber.length < 11) {
        return true;
    }

    return false;
}

// display success and error functions
function displayErrorMessage(message,timeout = 3000) {
   let errorMessage = $('<div>').addClass('popup error').text(message);
   $('body').append(errorMessage);
   

   setTimeout(function() {
       errorMessage.fadeOut(500, function() {
           errorMessage.remove();
       });
   }, timeout); // Display error message for 10 seconds
}

function displaySuccessMessage(message,timeout = 6000) {
   let successMessage = $('<div>').addClass('popup success').text(message);
   $('body').append(successMessage);
   setTimeout(function() {
       successMessage.fadeOut(500, function() {
           successMessage.remove();
       });
   }, timeout); // Display success message for 10 seconds
}

});
