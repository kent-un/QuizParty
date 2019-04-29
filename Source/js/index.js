function addReponse(x, y) {
    var reponse = '<div class="form-group"><label for="reponse">Réponse n°'+y+'</label><div class="input-group mb-3"><div class="input-group-prepend"><div class="input-group-text"><input type="checkbox" aria-label="Checkbox for following text input" name="check'+x+'[]" value="'+y+'"></div></div><input type="text" name="reponse'+x+'['+y+']" max-lenght="250" class="form-control" id="reponse'+x+'['+y+']"></div></div>';

    $(reponse).appendTo("#question"+x);
    y++;
    $('#addAnswer'+x).attr("onclick", "addReponse("+x+","+y+")");
};

$('.carousel').carousel({
    interval:false
});