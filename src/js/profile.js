jQuery(document).ready(function($){
    $('.profile-avatar').hover( function(){
        $('.userpic-edit').toggleClass('active');
    })
});

function showMoreDetails(){
    document.getElementById('div-profile-menu-more').style.display = null;
}

function hideMoreDetails(){
    document.getElementById('div-profile-menu-more').style.display = 'none';
}

function showImagePopup(){
    document.getElementById('user-pic-edit').style.display = null;
    hideMoreDetails();
}

function hideImagePopup(){
    document.getElementById('user-pic-edit').style.display = 'none';
}

function showAccountDetails(){
    document.getElementById('div-profileedit-account-dropdown').style.display = null;
}

function hideAccountDetails(){
    document.getElementById('div-profileedit-account-dropdown').style.display = 'none';
}