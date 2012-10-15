$(function() {

    $('#MenuPanel').on("click", ".botton", function(e) {
        $('.all').quicksand( $('.showothers li'), {
            duration: 3000,
            attribute: 'data-id'
        });
        e.preventDefault();
    });

    // ##### MENU #####
    // hover information panels
    $("#Menu").hoverIntent(showMenu,hideMenu);
    // Expand Menu touch screen
    $("#Open").click(showMenu);
    // Collapse Menu touch screen
    $("#Close").click(hideMenu);

    // ##### FOOTER #####
    // hover information panels
    $("#Footer").hoverIntent(showFoot,hideFoot);

    // ##### PHOTOS #####
    // thumbnail click
    $('#Photos').on("click", "li", function() {
        $('#Mask').fadeIn('200');
        var imageId = $(this).children("img").attr("id");
        var classId = $(this).attr("class");
        $(this).addClass('current');
        zoomImage(classId, imageId);
        $("."+classId).children("img").not(".show").fadeTo(200, 0.5);
        $('#Mask').addClass(classId);
        $('#Result').text(imageId);
        $("#"+imageId).hide();
        $("#form"+imageId).fadeIn('200');
        $("#Photos").removeClass("show");
    });
    /*$('#Photos').on("click", "li", function() {
     $('#Mask').fadeIn('200');
     var show = $(this).children("img").attr("id");
     var id = $(this).attr("class")
     $("."+id).children("img").animate({
     height: 1,
     }, 200);
     $('#Mask').addClass(id);

     $(".form").fadeOut('200');
     $('#Result').text(show);
     //$("#"+show).hide();
     $("#form"+show).fadeIn();
     });*/
    // close form
    $('#Photos').on("click", ".closeForm", function() {
        closeForm();
    });
    $('#Mask').click( function() {
        closeForm();
    });
    $('.closeForm').click( function() {
        closeForm();
    });

}); // close document.ready
// ##### MENU #####
function showMenu(){
    $("#MenuPanel").slideDown(300);
    $("#MenuTab a").toggle();
}

function hideMenu(){
    $("#MenuPanel").slideUp(300);
    $("#MenuTab a").toggle();
}

// ##### MENU #####
function showFoot(){
    $("#FooterPanel").slideDown(300);
}

function hideFoot(){
    $("#FooterPanel").slideUp(300);
}

function arangePhotos(){
    /*
    $('#Loading').show();
    var $broswerWidth = $(window).width();
    var $broswerHeight = $(window).height();
    var $ImgWidth = $('#Photos img:visible:first').width();
    var $ImgHeight = $('#Photos img:visible:first').height();
    var $ImagesAccross = Math.floor($broswerWidth / $ImgWidth);
    var $ImagesDown = Math.floor($broswerHeight / $ImgHeight);
    var $ImagesDisplayed = $ImagesAccross * $ImagesDown;
    var $NewWidth = $ImagesAccross * $ImgWidth;
    $('#Result').text($NewWidth);
    $("#PhotosList").load("loadphotos.php", {show: $ImagesDisplayed, accross: $ImagesAccross });
    $('#Loading').fadeOut('200');
    $('#Photos img').addClass('animated flipInY');
    $('#PhotosList').css("width", $NewWidth);
    */
}
function zoomImage(classId, imageId){
    var $broswerWidth = $(window).width();
    var $broswerHeight = $(window).height();

    var img = $('#' + imageId);
    var $Offset = img.offset();
//    var $Offset = $(".current img").offset();
    var $ImgTop = $Offset.top;
    var $ImgLeft = $Offset.left;
//    var $ImgWidth = $(".current").width();
//    var $ImgHeight = $(".current").height();
    var $ImgWidth = img.width();
    var $ImgHeight = img.height();
    var $FinalTop = ($broswerHeight / 2) - 149;
    var $FinalLeft = ($broswerWidth / 2) - 249;

    var $MoveTop = $FinalTop - $ImgTop;
    var $MoveLeft = $FinalLeft - $ImgLeft;

    img.addClass('show');
    img.css("left", $ImgLeft).css("top", $ImgTop);
    img.animate({
        left:$FinalLeft,
        top:$FinalTop,
        width:253,
        height:300
    }, 600).fadeTo(200, 0.5);
    img.animate({
        left:$ImgLeft,
        top:$ImgTop,
        width:$ImgWidth,
        height:$ImgHeight
    }).show();


    $("#PhotosList li").removeClass("current");
}
function closeForm(){
    var id = $("#Mask").attr("class");
    $("#Mask").fadeOut('200');
    $(".form").fadeOut('200');
//    $("."+id).children("img").fadeIn('200');
//    $("#PhotosList img").removeClass("show")
    $("#Mask").removeClass(id);

//    // Liam's hook
//    swapUnseenForSeenImage(id);
}
$(window).load(function() {
//    $('#Loading').fadeOut('200');
//    $('#Photos').fadeIn('2000');
//    arangePhotos();

});

var rtime = new Date(1, 1, 2000, 12,00,00);
var timeout = false;
var delta = 200;
$(window).resize(function() {
    rtime = new Date();
    if (timeout === false) {
        timeout = true;
        setTimeout(resizeend, delta);
    }
});

function resizeend() {
    if (new Date() - rtime < delta) {
        setTimeout(resizeend, delta);
    } else {
        timeout = false;
//        $('#Loading').fadeOut('200');
//        $('#Mask').fadeOut('200');
//        arangePhotos();
    }
}


// Liam's additions
var ROTATION_TIME = 5000;
var ROTATION_NUMBER = 1;
var MAX_IMG = 41;
var MAX_SHOW = 10;
var allImages = new Array(MAX_IMG);
var imagesInView = new Array(MAX_IMG);
var imagesRespondedTo = new Array();
var imagesUnseen = new Array();
var elements = [];



// http://stackoverflow.com/questions/1267283/how-can-i-create-a-zerofilled-value-using-javascript
/**
 * Generates a consistent zero-padded number.
 * For example, 'zeroPadLeft(number, width)' generates '0001'.
 *
 * @param number
 * @param width
 * @return {*}
 */
function zeroPadLeft(number, width) {
    width -= number.toString().length;
    if ( width > 0 ) {
        return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
    }
    return number;
}

/**
 * Loads images - needs to be replaced by dynamic call to load images from the database.
 */
function loadImages() {
    // Load images here
    for (var i = 0; i < MAX_IMG; i++) {
        var src = 'faces/thumbs/face_' + zeroPadLeft(i + 1, 4) + '.jpg';
        var img = new Image();
        img.src = src;
        img.id = zeroPadLeft(i + 1, 4);
        allImages[i] = img;
    }
}


/**
 * Shows all images
 */
function showImages() {
    var randomImages = _.shuffle(allImages);
    imagesInView = _.first(randomImages, MAX_SHOW);
    imagesUnseen = _.rest(randomImages, MAX_SHOW);
    var browserWidth = $(window).width();
    var browserHeight = $(window).height();
    var photoWidth = 106; //$('#Photos li').width();
    var photoHeight = 127; //$('#Photos li').height();
    var totalImages = Math.floor((browserWidth / photoWidth) * (browserHeight / photoHeight));
    // Add images dynamically here

    for (var i = 0; i < totalImages; i++) {
        var randomImage = Math.floor(Math.random() * imagesInView.length);
        addImageInstance(imagesInView[randomImage]);
    }
}

/**
 * Add an image instance to the page.
 * @param img
 * @param sibling
 */
function addImageInstance(img, sibling) {
    var id = img.id;
    var uniqueId = id + '_' + Math.floor(Math.random() * 1000);
    var liNode = ('<li data-id="' + id + '" id="img' + uniqueId + '" class="' + id + '"></li>');
    if (_.isUndefined(sibling)) {
        $('#ActualPhotoList').append(liNode);
    }
    else {
        sibling.after(liNode);
    }
    var currentImage = new Image();
    currentImage.src = img.src;
    currentImage.id = uniqueId;
    $('#img' + uniqueId).append(currentImage);
    $('#img' + uniqueId).append('<div id="form' + uniqueId + '" class="form"></div>');
    var img2 = new Image();
    img2.src = img.src;
    img2.height = 300;
    $('#form' + uniqueId).append('<div class="closeForm"></div>');
    $('#form' + uniqueId).append(img2);
}



/**
 * Swaps all instances of a given image (with a given class ID)
 * @param classId
 * @param newImage
 */
function swapAllInstancesOfImage(classId, newImage) {
    var newClassId = newImage.id;
    var classes = $('.' + classId);
    classes.attr('class', newClassId);
    classes.attr('data-id', newClassId);

    // Copy classes to a global elements array
    elements = [];
    classes.each(function(index, element) {
        elements.push(element);
    });

    setTimeout(function() {
        replaceAllInstancesOfImage(elements, newClassId, newImage)
    }, 250);
}

/**
 * Replaces all instances of an image
 * @param elements
 * @param newClassId
 * @param newImage
 */
function replaceAllInstancesOfImage(elements, newClassId, newImage) {
    var elem = _.first(elements),
        selector = $(elem);
    var uniqueId = newClassId + '_' + Math.floor(Math.random() * 1000);
    replaceImageInstance(selector, uniqueId, newImage)
    elements = _.rest(elements);
    if (elements.length > 0) {
        setTimeout(function() {
            replaceAllInstancesOfImage(elements, newClassId, newImage)
        }, 250);
    }
}

/**
 * Replaces a specific instance of an image
 * @param elem
 * @param newId
 * @param newImage
 */
function replaceImageInstance(elem, newId, newImage) {
    var replacementImage = new Image();
    replacementImage.src = newImage.src;
    replacementImage.id = newId;

    // Poor man's ticker - needs proper replacement
    // See jquery.flightboard for an approach to this
    elem.hide();
    elem.empty();
    elem.attr('id', 'img' + newId)
    elem.append(replacementImage)
    elem.append('<div id="form' + newId + '" class="form"></div>');
    $('#form' + newId).append('<div class="closeForm"></div>');
    var img2 = new Image();
    img2.src = newImage.src;
    img2.height = 300;
    $('#form' + newId).append(img2);
    elem.slideDown(250)
}

/**
 * Starts the rotation of images
 */
function startRotation() {
//    setTimeout(function() {
    setInterval(function() {
        console.log('doing rotation')
        for (var i = 0; i < ROTATION_NUMBER; i++) {
            var newImage = _.first(imagesUnseen);
            var oldImage = _.first(imagesInView);
            swapAllInstancesOfImage(oldImage.id, newImage);

            imagesInView = _.rest(imagesInView);
            imagesUnseen = _.rest(imagesUnseen);
            imagesInView.push(newImage)

            // For safe-keeping, store the ID
//            imagesRespondedTo.push(imgID);
        }
    }, ROTATION_TIME);
}

/**
 * Loads and shows images, and kicks off image rotations.
 */
function initialLoad() {
    loadImages();
    showImages();
    startRotation();
}