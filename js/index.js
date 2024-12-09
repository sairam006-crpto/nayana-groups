


  function sendMail() {
    var params = {
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
        // Address: document.getElementById("Address").value,
        message: document.getElementById("message").value,
        // company: document.getElementById("company").value
        
    };


const serviceID ="service_dxi4957";
const templateID ="template_b70oyrb";

emailjs 
    .send(serviceID, templateID, params)
    .then((res) => {
        document.getElementById("name").value = "";
        document.getElementById("email").value = "";
        // document.getElementById("Address").value ="";
        document.getElementById("message").value = "";
        // document.getElementById("company").value ="";
        console.log(res);
        alert("your message sent successfully");

    })
    .catch((err) => console.log(err));
}