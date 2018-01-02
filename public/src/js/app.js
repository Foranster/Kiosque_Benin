var postId = 0;
var postBodyElement = null;
var postTitleElement = null;

$('#myCarousel').carousel({
    interval: 5000
});

$('#accordion').find('.card-body').find('.edit').on('click', function (event) {
    event.preventDefault();
    slideTitleElement = event.target.parentNode.parentNode.childNodes[1].childNodes[1].childNodes[2];
    var slideTitle = slideTitleElement.textContent;
    slideDescriptionElement = event.target.parentNode.parentNode.childNodes[1].childNodes[3].childNodes[2];
    var slideDescription = slideDescriptionElement.textContent;
    slideId = event.target.parentNode.parentNode.parentNode.dataset['slideid'];
    console.log(slideId);
    $('#slide-title').val(slideTitle);
    $('#slide-description').val(slideDescription);
    $('#edit-modal').modal();
});

$('#modal2-save').on('click', function () {
    $.ajax({
        method: 'POST',
        url: urlEdit,
        data: {
            title: $('#slide-title').val(),
            description: $('#slide-description').val(),
            slideId: slideId,
            _token: token
        }
    })
        .done(function (msg) {
            $(slideTitleElement).text(msg['new_title']);
            $(slideDescriptionElement).text(msg['new_description']);
            $('#edit-modal').modal('hide');
        })
});

$('.post').find('.interaction').find('.edit').on('click', function (event) {
    event.preventDefault();
    postBodyElement = event.target.parentNode.parentNode.childNodes[3].childNodes[3];
    var postBody = postBodyElement.textContent;
    postTitleElement = event.target.parentNode.parentNode.childNodes[3].childNodes[1];
    var postTitle = postTitleElement.textContent;
    postId = event.target.parentNode.parentNode.dataset['postid'];
    $('#post-body').val(postBody);
    $('#post-title').val(postTitle);
    $('#edit-modal').modal();
});

$('#modal-save').on('click', function () {
    $.ajax({
        method: 'POST',
        url: urlEdit,
        data: {
            title: $('#post-title').val(),
            body: $('#post-body').val(),
            postId: postId,
            _token: token
        }
    })
        .done(function (msg) {
            $(postBodyElement).text(msg['new_body']);
            $(postTitleElement).text(msg['new_title']);
            $('#edit-modal').modal('hide');
        })
});

$('.like').on('click', function (event) {
    event.preventDefault();
    var isLike = event.target.previousElementSibling == null;
    postId = event.target.parentNode.parentNode.dataset['postid'];
    $.ajax({
        method: 'POST',
        url: urlLike,
        data: {
            isLike: isLike,
            postId: postId,
            _token: token
        }
    })
        .done(function () {
            event.target.innerText = isLike ? event.target.innerText == 'Aimer' ? 'J\'ai aimé' : 'Aimer' : event.target.innerText == 'Détester'
                ? 'J\'ai détesté' : 'Détester';
            if(isLike){
                event.target.nextElementSibling.innerText = 'Détester';
            }else{
                event.target.previousElementSibling.innerText = 'Aimer';
            }
        })
});

$(".news").mCustomScrollbar({
    theme: 'inset',
    scrollInertia: 400
});

