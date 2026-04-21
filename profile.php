<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
 <link rel="stylesheet" href="/afro/theme.css">
</head>
<body>
<script>
// Tab switching
document.querySelectorAll('.tab-btn').forEach(function(btn){
    btn.addEventListener('click', function(){
        var tab = this.dataset.tab;
        document.querySelectorAll('.tab-btn').forEach(function(b){ b.classList.remove('active'); });
        document.querySelectorAll('.tab-panel').forEach(function(p){ p.classList.remove('active'); });
        this.classList.add('active');
        document.getElementById('panel-' + tab).classList.add('active');
        history.replaceState(null,'','/afro/profile.php?tab=' + tab);
    });
});

// Avatar live preview
document.getElementById('avatar-input') && document.getElementById('avatar-input').addEventListener('change', function(){
    var file = this.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function(e){
        var prev = document.getElementById('avatar-preview');
        var init = document.getElementById('avatar-preview-initial');
        if (prev) {
            prev.src = e.target.result;
        } else if (init) {
            var img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'avatar-preview';
            img.id = 'avatar-preview';
            img.alt = 'avatar';
            init.replaceWith(img);
        }
    };
    reader.readAsDataURL(file);
});
</script>
</body>
</html>
