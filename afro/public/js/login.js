document.addEventListener('DOMContentLoaded', function(){
    var form = document.getElementById('login-form');
    if (!form) return;
    form.addEventListener('submit', function(e){
        // trivial client-side check
        var id = form.querySelector('input[name="identifier"]').value.trim();
        var pw = form.querySelector('input[name="password"]').value;
        if (!id || !pw) {
            e.preventDefault();
            alert('Enter username/email and password');
        }
    });
});
