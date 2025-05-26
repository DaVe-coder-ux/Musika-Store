const container=document.querySelector('.container');
const LoginLink=document.querySelector('.signInLink');
const RegisterLink=document.querySelector('.signUpLink');
const loginCloseBtn=document.querySelector('.login-close');
const regCloseBtn=document.querySelector('.reg-close');
RegisterLink.addEventListener('click',()=>{
    container.classList.add('active');
})
LoginLink.addEventListener('click',()=>{
    container.classList.remove('active');
})
loginCloseBtn.addEventListener('click', ()=> {
    container.classList.remove('active');
})
regCloseBtn.addEventListener('click', ()=> {
    container.classList.remove('active');
})
function closeForm() {
    const container=document.querySelector('.container');
    container.classList.remove('active');

    const modalToggle=document.getElementById('modal-togle');
    if (modalToggle) {
        modalToggle.checked=false;
    }
}