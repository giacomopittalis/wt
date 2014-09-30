$("#info-btn").click(function()
{
    $(".consult-list li").removeClass("active");
    $(this).addClass("active");
    $("#info").fadeIn();$("#topic").fadeOut();$("#soap").fadeOut();
});

$("#topic-btn").click(function()
{
    $(".consult-list li").removeClass("active");
    $(this).addClass("active");
    $("#info").fadeOut();$("#topic").fadeIn();$("#soap").fadeOut();
});

$("#soap-btn").click(function(){
    $(".consult-list li").removeClass("active");
    $(this).addClass("active");
    $("#info").fadeOut();$("#topic").fadeOut();$("#soap").fadeIn();
});