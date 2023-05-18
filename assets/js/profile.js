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
    $('.userpic').removeClass('hidden');
    hideMoreDetails();
}

$('.userpic-popup-close').click(function(){
    $('.userpic').addClass('hidden');
});

$('#userpic-file-load').click(function(){
    $("#picture-new-file").click()
});

function hideImagePopup(){
    document.getElementById('user-pic-edit').style.display = 'none';
}

function showAccountDetails(){
    document.getElementById('div-profileedit-account-dropdown').style.display = null;
}

function hideAccountDetails(){
    document.getElementById('div-profileedit-account-dropdown').style.display = 'none';
}

