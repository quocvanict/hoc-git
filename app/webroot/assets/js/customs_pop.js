var SUCCESS = '<i class="glyphicon glyphicon-ok" style="color: #36a9e1;"></i>&nbsp;&nbsp;成功';
var ERROR = '<i class="fa fa-exclamation-triangle" style="color: red;"></i>&nbsp;&nbsp;エラー';
$(document).ready(function () {
    $(document).ajaxError(function (event, jqxhr, settings, thrownError) {
        if (jqxhr.status == 403) {
            window.location = 'auth/login';
        } else {
            // Common.notification(ERROR, 'Error while process data !!!');
        }
    });
//    $('.jqiclose').click(function () {
//        location.reload();
//    });
    $('.use_proxy').change(function () {
        if ($(this).is(':checked')) {
            $(this).siblings('input[type=hidden]').attr('disabled', true);
        } else {
            $(this).siblings('input[type=hidden]').attr('disabled', false);
        }
    });
    $(document).on('click', 'button.rm_proxy', function () {
        var cf = confirm('I want delete?');
        if (cf) {
            $(this).parents('tr').remove();
        }
    });

    $('#more_proxy').click(function () {
        addNewProxyRow("", "", ['IP', 'Port']);
    });

    // find artist in album auto complete
    $("#album_artist_autocomplete").autocomplete({
        minLength: 1,
        source: function (request, response) {
            $.ajax({
                url: "artist/search",
                type: "POST",
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function (data) {
                    response(data.data);
                }
            });
        },
        focus: function (event, ui) {
            // $( "input[name='album[artist_id]']", "#frm-album-edit").val( ui.item.id );
            // $( "input[name='album[artist_name]']", "#frm-album-edit").val( ui.item.name );
            return false;
        },
        select: function (event, ui) {
            $("input[name='album[artist_id]']", "#frm-album-edit").val(ui.item.id);
            $("input[name='album[artist_name]']", "#frm-album-edit").val(ui.item.name);
            return false;
        }
    })
            .autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
                .append("<a>" + item.name + "</a>")
                .appendTo(ul);
    };

    // find song in album
    $("#search_song_for_album").autocomplete({
        minLength: 1,
        source: function (request, response) {
            $.ajax({
                url: "song/search",
                type: "POST",
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function (data) {
                    response(data.data);
                }
            });
        },
        focus: function (event, ui) {
            return false;
        },
        select: function (event, ui) {
            ui.item.size = $("#sortable tr").length;
            html = new EJS({url: 'assets/template/album-song-item.ejs'}).render(ui.item);
            $(".song-list").append(html);
            $("#search_song_for_album").val('');
            return false;
        }
    })
            .autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
                .append("<a><b>" + item.name + "</b> - " + item.artist_name + "</a>")
                .appendTo(ul);
    };


    // sort song in album
    $("#sortable").sortable({
        update: function (event, ui) {
            $("#sortable tr").each(function (index) {
                $(this).find('.album_track').val(index);
            });
        }
    });


    // artist
    $(".editinline-rank-artist").on("DOMCharacterDataModified", function () {
        var id = $(this).attr('data-artist-id');
        var ranking = $(this).text()
        Artist.save_ranking(id, ranking);
    });

    // app search
    $(".btn-search-type").on("click", function () {
        $(".btn-search-type").removeClass('btn-primary');
        $(this).addClass('btn-primary');
        var search_type = $(this).attr('data-search-type');
        $("input[name='search[type]']", "#frm-app-search").val(search_type);
        App.search();
    });

});

var Common = new function () {
    this.notification = function (title, text, image) {
        if (text == '') {
            text = ' ';
        }
        $.gritter.add({
            title: title,
            text: text,
            image: image,
            sticky: false,
            time: 1000
        });
    };
    this.showLoading = function () {
        $('.page-loading').css('display', 'block');
    };

    this.closeLoading = function () {
        $('.page-loading').fadeOut('slow');
    };
    this.showPopup = function (data) {
        $.prompt(data, {
            show: "slideDown",
            top: "15%",
            buttons: {},
            opacity: 0.15,
            persistent: false,
            zIndex: 999
        });
        return false;
    };

    this.closePopup = function () {
        location.reload();
        $('.jqibox').remove();
//        location.reload();

    };

    this.showValidation = function (formElement, validationErrors, prefix) {
        $('.error', formElement).hide().text('');
        $('.has-error', formElement).removeClass('has-error');
        for (var fieldName in validationErrors) {
            if (prefix) {
                $input = $("[name='" + prefix + "[" + fieldName + "]' ]", formElement);
            } else {
                $input = $("[name='" + fieldName + "']", formElement);
            }
            $input.parent().find('.error').text(validationErrors[fieldName]).show();
            $input.parent().addClass('has-error');
        }
        ;
    };

    this.loadPopup = function (url) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            data: {ajax: true},
            success: function (data) {
                Common.showPopup(data);
            }
        });
        return false;
    };
};

var Storage = new function () {
    this.set = function (key, value) {
        if (typeof (Storage) !== 'undefined') {
            localStorage.setItem(key, value);
        }
    };
    this.get = function (key) {
        if (typeof (Storage) !== 'undefined') {
            return localStorage.getItem(key);
        }
    };
};


function addNewProxyRow(pKey, pValue, placeholder)
{
    Xnew_row_html = '<tr class="test"><td><button class="btn btn-default rm_proxy" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td><td class="pa"><input class="form-control col-lg-7" type="text" name="params[]" placeholder="' + placeholder[0] + '" value = "' + (!pKey ? '' : pKey) + '"></td><td class="value"><input class="va form-control col-lg-7"" type="text" name="values[]" placeholder="' + placeholder[1] + '" value = "' + ((!pValue || pValue === null) ? '' : pValue) + '"></td><td><input type="checkbox" name="checked[]" value="1" class="use_proxy"/><input type="hidden" class="hidden_use_proxy" name="checked[]" value="0" /></td></tr>';
    if ($('#paramTable tr:last') != null) {
        $('#paramTable tr:last').after(Xnew_row_html);
    } else {
        $('#paramTable tbody').html(Xnew_row_html);
    }
    $("table td span.delParam").unbind('click');
    $("table td span.delParam").click(function () {
        $(this).parent().parent().fadeTo(400, 0, function () {

            $(this).remove();
        });
        return false;
    });
}


var Artist = new function () {
    this.save = function () {
        Common.showLoading();
        $('button[type=submit]', '#frm-artist-edit').attr('disabled', 'disabled');
        $.ajax({
            url: 'artist/edit',
            type: 'POST',
            dataType: 'json',
            data: $('#frm-artist-edit').serialize(),
            success: function (data) {
                $('button[type=submit]', '#frm-artist-edit').removeAttr('disabled');
                Common.closeLoading();
                if (data.code == 'OK') {
                    Common.notification('SUCCESS', data.message);
                    Common.closePopup();
                } else if (data.code == 'ERROR_VALIDATION') {
                    Common.showValidation('#frm-artist-edit', data.data, 'artist');
                } else {
                    Common.notification('ERROR', data.message);
                }
            }
        });
        return false;
    };

    this.save_ranking = function (id, ranking) {
        if (ranking % 1 === 0) {
            $.ajax({
                url: 'artist/save_ranking',
                type: 'POST',
                dataType: 'json',
                data: {id: id, ranking: ranking},
                success: function (data) {

                }
            });
        }
    }
    this.delete = function (id) {
        if (confirm("Are you want remove this artist?") == true) {
            $.ajax({
                url: 'artist/delete',
                type: 'POST',
                dataType: 'json',
                data: {id: id},
                success: function (data) {
                    if (data.code == 'OK') {
                        $(".artist-list tr[data-artist-id=" + id + "]").hide();
                        Common.notification('Success', data.message);
                    }
                }
            });
        }
    }
};

var Album = new function () {
    this.save = function () {
        Common.showLoading();
        $('button[type=submit]', '#frm-album-edit').attr('disabled', 'disabled');
        $.ajax({
            url: 'album/edit',
            type: 'POST',
            dataType: 'json',
            data: $('#frm-album-edit').serialize(),
            success: function (data) {
                $('button[type=submit]', '#frm-album-edit').removeAttr('disabled');
                Common.closeLoading();
                if (data.code == 'OK') {
                    Common.notification('SUCCESS', data.message);
                    if ($("input[name='album[id]']").val() == 0) {
                        window.location.href = BASE_URL + "album";
                    }
                } else if (data.code == 'ERROR_VALIDATION') {
                    Common.showValidation('#frm-album-edit', data.data, 'album');
                } else {
                    Common.notification('ERROR', data.message);
                }
            }
        });
        return false;
    };

    this.delete = function (id) {
        if (confirm("Are you want remove this album?") == true) {
            $.ajax({
                url: 'album/delete',
                type: 'POST',
                dataType: 'json',
                data: {id: id},
                success: function (data) {
                    if (data.code == 'OK') {
                        $(".album-list tr[data-album-id=" + id + "]").hide();
                        Common.notification('Success', data.message);
                    }
                }
            });
        }
    };

    this.remove = function (song_id) {
        if (confirm("Are you want remove this song from album?") == true) {
            $(".song-list tr[data-song-id=" + song_id + "]").hide();
            $("input[name='album[songs][" + song_id + "]']").val('-1');
        }
    };
};

var Song = new function () {
    this.save = function () {
        Common.showLoading();
        $('button[type=submit]', '#frm-song-edit').attr('disabled', 'disabled');
        $.ajax({
            url: 'song/edit',
            type: 'POST',
            dataType: 'json',
            data: $('#frm-song-edit').serialize(),
            success: function (data) {
                $('button[type=submit]', '#frm-song-edit').removeAttr('disabled');
                Common.closeLoading();
                if (data.code == 'OK') {
                    Common.notification('SUCCESS', data.message);
                    Common.closePopup();
                } else if (data.code == 'ERROR_VALIDATION') {
                    Common.showValidation('#frm-song-edit', data.data, 'song');
                } else {
                    Common.notification('ERROR', data.message);
                }
            }
        });
        return false;
    };

    this.delete = function (id) {
        if (confirm("Are you want delete this song?") == true) {
            $.ajax({
                url: 'song/delete',
                type: 'POST',
                dataType: 'json',
                data: {id: id},
                success: function (data) {
                    if (data.code == 'OK') {
                        $(".song-list tr[data-song-id=" + id + "]").hide();
                        Common.notification('Success', data.message);
                    }
                }
            });
        }
    };

    this.preview_video = function (youtube_id) {
        if (youtube_id) {
            var html = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + youtube_id + '?autoplay=1" frameborder="0" allowfullscreen></iframe>';
            Common.showPopup(html);
        }
    }

    this.apply_autocomplete = function () {
        // find artist in song auto complete
        $("#song_artist_autocomplete").autocomplete({
            minLength: 1,
            source: function (request, response) {
                $.ajax({
                    url: "artist/search",
                    type: "POST",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function (data) {
                        response(data.data);
                    }
                });
            },
            focus: function (event, ui) {
                // $( "input[name='song[artist_id]']", "#frm-song-edit").val( ui.item.id );
                // $( "input[name='song[artist_name]']", "#frm-song-edit").val( ui.item.name );
                return false;
            },
            select: function (event, ui) {
                $("input[name='song[artist_id]']", "#frm-song-edit").val(ui.item.id);
                $("input[name='song[artist_name]']", "#frm-song-edit").val(ui.item.name);
                return false;
            }
        })
                .autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                    .append("<a>" + item.name + "</a>")
                    .appendTo(ul);
        };

        // find album in song auto complete
        $("#song_album_autocomplete").autocomplete({
            minLength: 1,
            source: function (request, response) {
                $.ajax({
                    url: "album/search",
                    type: "POST",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function (data) {
                        response(data.data);
                    }
                });
            },
            focus: function (event, ui) {
                // $( "input[name='song[album_id]']", "#frm-song-edit").val( ui.item.id );
                // $( "input[name='song[album_name]']", "#frm-song-edit").val( ui.item.name );
                return false;
            },
            select: function (event, ui) {
                $("input[name='song[album_id]']", "#frm-song-edit").val(ui.item.id);
                $("input[name='song[album_name]']", "#frm-song-edit").val(ui.item.name);
                return false;
            }
        })
                .autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                    .append("<a>" + item.name + "</a>")
                    .appendTo(ul);
        };
    }

    this.show_box_search_video = function () {
        $('.input-search-video').show();
        Song.search_video();
    };

    this.search_video = function () {
        $("#search-video-box").html('<center>Loading...</center>');
        var keyword = $("input[name='video_keyword']").val();
        if (keyword) {
            $.ajax({
                type: 'POST',
                url: 'song/search_video',
                dataType: 'json',
                data: {keyword: keyword},
                success: function (data) {
                    if (data.code == 'OK') {
                        html = new EJS({url: 'assets/template/video-list.ejs'}).render(data.data);
                        $('#search-video-box').html(html);
                    } else {
                        $('#search-video-box').html('<center>' + data.message + '</center>');
                    }
                }
            });
        }
    };

    this.play_video = function ($elm) {
        if (!$elm) {
            var video_id = $("input[name='song[video_id]']").val();
            var video_title = $("input[name='song[video_title]']").val();
        } else {
            var video_id = $elm.attr('data-video-id');
            var video_title = $elm.attr('data-video-title');
        }
        if (video_id) {
            $('#video-player').html('<center><iframe width="560" height="315" src="https://www.youtube.com/embed/' + video_id + '?autoplay=1" frameborder="0" allowfullscreen></iframe><br/><button type="button" onclick="Song.select_video($(this))" data-video-id="' + video_id + '" data-video-title="' + video_title + '" class="btn btn-primary">SELECT THIS VIDEO</button> <a target="_blank" href="https://www.youtube.com/watch?v=' + video_id + '" class="btn btn-primary">View On Youtube</a></center><br/>');
        }
    };

    this.select_video = function ($elm) {
        $('input[name="song[video_id]"]').val($elm.attr('data-video-id'));
        $('input[name="song[video_title]"]').val($elm.attr('data-video-title'));
    }
}

var App = new function () {
    this.APIKEY = "82:61:52:E8:28:B2:85:98:D0:99:01:97:BE:78:DC:66:52:78:F0:17";
    this.VERSION = "1.0";
    this.API_DIR = "api_v4/";

    this.callApi = function (url, params, cb) {
        Common.showLoading();
        var expired = parseInt(new Date().getTime() / 1000) + 60 * 60;
        var token = md5("" + App.APIKEY + expired);
        var version = App.VERSION;
        params.expired = expired;
        params.token = token;
        params.version = version;
        $.ajax({
            url: App.API_DIR + url,
            type: 'POST',
            dataType: 'json',
            data: params,
            success: function (response) {
                Common.closeLoading();
                cb(response);
            }
        });

    }

    this.search = function (page) {
        var keyword = $("input[name='search[keyword]']").val();
        var search_type = $("input[name='search[type]']").val();
        var url = "";
        if (!page) {
            page = 1;
        }
        if (search_type == "song") {
            url = "song/";
        } else if (search_type == "album") {
            url = "album/";
        } else {
            url = "artist/";
        }

        App.callApi(url, {
            'keyword': keyword,
            'page': page
        }, function (response) {
            if (search_type == "song") {
                App.showResultSong(response, page);
            } else if (search_type == "album") {
                App.showResultAlbum(response, page);
            } else {
                App.showResultArtist(response, page);
            }
        });
        return false;
    };

    this.song_detail = function (id, video_id) {
        if (!video_id) {
            App.callApi("song/detail", {
                'id': id
            }, function (response) {
                if (response.code == 'OK') {
                    Song.preview_video(response.data.video_id);
                }
            });
        } else {
            Song.preview_video(video_id);
        }
    };

    this.song_detail

    this.showResultSong = function (response, page) {
        if (response.code !== "OK") {
            Common.notification('Error', response.message);
            $("#result").html("");
        } else {
            html = new EJS({url: 'assets/template/app/songs.ejs'}).render(response.data);
            if (page == 1) {
                $("#result").html(html);
            } else {
                $(".btn-loadmore").hide();
                $("#result").append(html);
            }
        }
    }

    this.showResultAlbum = function (response, page) {
        if (response.code !== "OK") {
            Common.notification('Error', response.message);
            $("#result").html("");
        } else {
            html = new EJS({url: 'assets/template/app/albums.ejs'}).render(response.data);
            if (page == 1) {
                $("#result").html(html);
            } else {
                $(".btn-loadmore").hide();
                $("#result").append(html);
            }
        }
    }

    this.showResultArtist = function (response, page) {
        if (response.code !== "OK") {
            Common.notification('Error', response.message);
            $("#result").html("");
        } else {
            html = new EJS({url: 'assets/template/app/artists.ejs'}).render(response.data);
            if (page == 1) {
                $("#result").html(html);
            } else {
                $(".btn-loadmore").hide();
                $("#result").append(html);
            }
        }
    }
}