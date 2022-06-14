
const contactForm = document.querySelector('#contact-form');

if (contactForm != null){
contactForm['submit'].addEventListener('click', function(e){
    e.preventDefault();
})
}

function submitContactForm(){
    const formSending = document.querySelector('.form-sending');
    formSending.style.display = 'block';

    if(isFormReady()){
    var fd = new FormData();
    fd.append('contactFormSubmit', '1');
    fd.append('fname',jQuery('#fname').val());
    fd.append('lname',jQuery('#lname').val());
    fd.append('email',jQuery('#user-email').val());
    fd.append('phone',jQuery('#user-phone').val());
    fd.append('file', jQuery('#files')[0].files[0]);
    js_submit(fd);
    }else{
        errorMessage('Error: please double check your inputs!');
    }
    
}

function submit_contact_form_callback(data){
    
    var jdata = JSON.parse(data);

    if(jdata.success === 1){
        contactForm.innerHTML = '<div style="background-color: #fff;"><p style="color:red; text-align: center;">'+jdata.message+'</p></div>';
    }

}

function js_submit(fd){

    var submitUrl = 'send_form.php';

    jQuery.ajax({
        type:'post',
        url:submitUrl,
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){ 
            submit_contact_form_callback(response); 
            // console.log(response);
        }
    });

}

function isFormReady(){
    let isReady = 1;
    const firstName = contactForm['fname'];
    const lastName = contactForm['lname'];
    const email = contactForm['email'];
    const phone = contactForm['phone'];

    const nameRegEx = /[^a-zA-Z- ]/;
    const emailRegEx = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    const phoneRegEx = /\d?\(?[0-9]{3}\)?[-.\s]?[0-9]{3}[-.\s]?[0-9]{4}$/;

    if(!firstName.value){
        firstName.nextSibling.textContent = 'First Name is required';
        isReady = 0;
    }else if (nameRegEx.test(firstName.value)){
        firstName.nextSibling.textContent = 'You can only use letters';
        isReady = 0;
    }else{
        firstName.nextSibling.textContent = '';
    }

    if(!lastName.value){
        lastName.nextSibling.textContent = 'Last Name is required';
        isReady = 0;
    }else if (nameRegEx.test(lastName.value)){
        lastName.nextSibling.textContent = 'You can only use letters';
        isReady = 0;
    }else{
        lastName.nextSibling.textContent = '';
    }

    if(!email.value){
        email.nextSibling.textContent = 'Email is required';
        isReady = 0;
    }else if (!emailRegEx.test(email.value)){
        email.nextSibling.textContent = 'Not proper email format';
        isReady = 0;
    }else{
        email.nextSibling.textContent = '';
    }

    if(!phone.value){
        phone.nextSibling.textContent = 'Phone is required';
        isReady = 0;
    }else if (!phoneRegEx.test(phone.value)){
        phone.nextSibling.textContent = 'Not proper phone format';
        isReady = 0;
    }else{
        phone.nextSibling.textContent = '';
    }


    return isReady;

}

function errorMessage(err){
    const errorContainer = document.querySelector('.form-error');
    errorContainer.style.display = 'block';

    const formSending = document.querySelector('.form-sending');

    if(formSending.style.display === 'block'){
        formSending.style.display = 'none';
    }
    

    errorContainer.innerHTML = '<p>'+err+'</p>';
}
