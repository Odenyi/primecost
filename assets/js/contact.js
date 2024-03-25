$(document).ready(function() {

$("#contactbtn").click(function(e) {
        
    e.preventDefault()
    let name = $("#name").val();
    let  email = $("#email").val();
   
    let message = $("#exampleFormControlTextarea1").val();
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
                $("#email").val('');
                $("#phone").val('');
                $("#exampleFormControlTextarea1").val('');
                
                displaySuccessMessage("Hi " +name+ ", I have received your request and I will Contact you. Thank you")

                
            }

            else{
                displayErrorMessage("The was an error while submitting your data "+response,30000)
            }
        }
    });
});
});