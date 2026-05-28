// minimal client-side enhancements for signup form
document.addEventListener('DOMContentLoaded', function(){
    var form = document.getElementById('signup-form');
    if (!form) return;
    form.addEventListener('submit', function(e){
        // tiny client-side password match check
        var p = form.querySelector('input[name="password"]').value;
        var c = form.querySelector('input[name="password_confirm"]').value;
        if (p !== c) {
            e.preventDefault();
            alert('Passwords do not match');
        }
    });
});
