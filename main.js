$(document).ready(function () {
    loadNews();
    $('#news-form').submit(function (event) {
        event.preventDefault();

        var newsId = $('#news-id').val();
        var newsTitle = $('#news-title').val();
        var newsDescription = $('#news-description').val();
        var url = newsId ? 'process_news.php?action=update' : 'process_news.php?action=create';

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                id: newsId,
                title: newsTitle,
                description: newsDescription
            },
            dataType: 'json',
            success: function (response) {
                var responseMessage = response.message;
                if (response.status === 'success') {
                    $('#news-form')[0].reset();
                    $('#reset-form').trigger('click');
                    loadNews();
                    successMessage(responseMessage);
                } else {
                    errorMessage(responseMessage);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    // Function to handle news deletion
    $(document).on('click', '.delete-btn', function (event) {
        event.preventDefault();
        var newsId = $(this).data('id');

        $.ajax({
            url: 'process_news.php?action=delete',
            type: 'POST',
            data: {
                id: newsId
            },
            dataType: 'json',
            success: function (response) {
                var responseMessage = response.message;
                if (response.status === 'success') {
                    loadNews();
                    successMessage(responseMessage);
                } else {
                    errorMessage(responseMessage);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    $(document).on('click', '.edit-btn', function (event) {
        event.preventDefault();
        var newsId = $(this).data('id');

        $.ajax({
            url: 'process_news.php?action=read',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var responseMessage = response.message;
                if (response.status === 'success') {
                    var news = response.data.find(function (news) {
                        return news.id == newsId;
                    });

                    if (news) {
                        $('#news-form h3').text('Edit News');
                        $('#news-id').val(news.id);
                        $('#news-title').val(news.title);
                        $('#news-description').val(news.description);
                        $('#news-form').attr('action',
                            'process_news.php?action=update');
                        $('#news-form button[type="submit"]').text('Update');
                        $('#reset-form').show();

                    }
                } else {
                    errorMessage(responseMessage);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    $('#reset-form').click(function (event) {
        event.preventDefault();
        $('#news-form h3').text('Create News');
        $('#news-id').val('');
        $('#news-title').val('');
        $('#news-description').val('');
        $('#news-form').attr('action', 'process_news.php?action=create');
        $('#news-form button[type="submit"]').text('Create');
        $(this).hide();
    });



    // Cancel button click event
    $('#news-form #cancel-btn').click(function () {
        $('#news-id').val('');
        $('#news-title').val('');
        $('#news-description').val('');
        $('#news-form button[type="submit"]').text('Create');
    });

    $('#news-form #cancel-btn').click(function () {
        $('#news-form').attr('action', 'process_news.php?action=create');
        $('#news-form')[0].reset();
        $('#news-form button[type="submit"]').text('Create');
        $('#news-form #cancel-btn').hide();
    });


    $('#news-form #cancel-btn').click(function () {
        $('#news-form').attr('action', 'process_news.php?action=create');
        $('#news-form')[0].reset();
        $('#news-form button[type="submit"]').text('Create');
        $('#news-form #cancel-btn').hide();
    });

    function successMessage(message) {
        $('#message').removeClass('alert-error').addClass('alert-success');
        $('#message').text(message).show();

        setTimeout(function () {
            $('#message').hide();
        }, 3000);
    }

    function errorMessage(message) {
        $('#message').removeClass('alert-success').addClass('alert-error');
        $('#message').text(message).show();
        setTimeout(function () {
            $('#message').hide();
        }, 3000);
    }

    function loadNews() {
        $.ajax({
            url: 'process_news.php?action=read',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var responseMessage = response.message;
                if (response.status === 'success') {
                    newsItemsData = response.data;
                    var newsHtml = '';
                    newsHtml += '<h3>All News</h3>';
                    newsHtml += '<table class="table-div">';
                    newsHtml += '<tbody>';
                    newsItemsData.forEach(function (news) {
                        var deleteBtn =
                            '<a href="process_news.php?action=delete" class="delete-btn" data-id="' +
                            news.id +
                            '"><img src="images/close.svg" style="height:15px;" alt="Delete"></a>';
                        var editBtn =
                            '<a href="#" class="edit-btn" data-id="' +
                            news.id +
                            '"><img src="images/pencil.svg" style="height:15px" alt="Edit"></a>';
                        newsHtml += '<tr>';
                        newsHtml += '<td>' + news.title + ' ' + news.description +
                            '</td>';
                        newsHtml += '<td>' + editBtn + deleteBtn + '</td>';
                        newsHtml += '</tr>';
                    });

                    newsHtml += '</tbody>';
                    newsHtml += '</table>';
                    $('#news').html(newsHtml);
                    $('#news').show();

                } else {
                    errorMessage(responseMessage);

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                errorMessage(textStatus);
            }
        });
    }
    // Function to handle login form submission
    $('#login-form').submit(function (event) {
        event.preventDefault();
        var username = $('#username').val();
        var password = $('#password').val();
        $.ajax({
            url: 'process_login.php',
            type: 'POST',
            data: {
                username: username,
                password: password
            },
            dataType: 'json',
            success: function (response) {
                var responseMessage = response.message;
                if (response.status === 'success') {
                    $('#login-form').hide();
                    $('#app').show();
                    successMessage(responseMessage);
                } else {
                    errorMessage(responseMessage);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    // Function to handle logout
    $('#logout-btn').click(function () {
        event.preventDefault();
        $.ajax({
            url: 'process_login.php',
            type: 'GET',
            data: {
                action: 'logout'
            },
            dataType: 'json',
            success: function (response) {
                var responseMessage = response.message;
                if (response.status === 'success') {
                    $('#login-form').show();
                    $('#app').hide();
                    $('#message').removeClass('alert-error').addClass('alert-success');
                    $('#message').text(response.message).show();
                    successMessage(responseMessage);
                } else {
                    errorMessage(responseMessage);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Handle AJAX error
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    });


    // Function to check login status on page load
    $.ajax({
        url: 'process_login.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var responseMessage = response.message;
            if (response.status === 'success') {
                $('#login-form').hide();
                $('#app').show();
            } else {
                $('#login-form').show();
                $('#app').hide();

                errorMessage(responseMessage);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
});