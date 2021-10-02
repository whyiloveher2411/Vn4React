document.getElementById('menuToggle').addEventListener('click',function(){
    this.classList.toggle('active');
    var x = document.getElementById("myTopnav");
    if( this.classList.contains('active') ){
        x.className += " responsive";
    }else{
        x.className = "nav";
    }
});