$(function () {
    let hrefs = $('.col-sm-12').children('b');
    let comment_form = $('#form-review');
    let action = comment_form.attr('action');
    let input = $('#input-review');
    let parent_user;
    let submit_button = $('#button-review');

    hrefs.each(function () {
        $(this).on('click', function () {

            parent_user = $(this).children('a').text();
            input.text(parent_user + ' ');

            comment_form.attr('action', action + '&' + 'parent_id=' + (+$(this).children('a').attr('id').match(/\d+/)[0]));
        })
    });

    submit_button.on('click', function () {


        $.post(
            comment_form.attr('action'),
            {

            }
        );
    })
});