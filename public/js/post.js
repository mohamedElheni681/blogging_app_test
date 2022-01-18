function deletePost(formId) {
    Swal.fire({
        title: 'Are you sure you want to delete this post?',
        html: 'This action is irreversible.<br><br><br><br> Do you want to continue?',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Validate',
        showCloseButton: true,
        focusConfirm: false,
        width: 648,
        padding: '2em',
    }).then((result) => {
        if (result.isConfirmed) {
        $(`#${formId}`).submit();
        }
    })
}


function initialiseEditor() {
    let toolbarOptions = getToolbarOptions();

    Quill.prototype.setHTML = function (html) {
        this.container.querySelector('.ql-editor').innerHTML = html;
    };

    let quill = new Quill('#post_text', {
        modules: {
            toolbar: toolbarOptions
        },
        placeholder: 'Add the post description...',
        theme: 'snow'  // or 'bubble'
    });

    return quill;
}


function isEditorEmpty(value) {
    if (value.replace(/<(.|\n)*?>/g, '').trim().length === 0 && !value.includes("<img")) {
        return true;
    }
    return false;
}


function getToolbarOptions() {
    var toolbarOptions = [
        ['link', 'image'],
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],

        [{'header': 1}, {'header': 2}],               // custom button values
        [{'list': 'ordered'}, {'list': 'bullet'}],
        [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
        [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
        [{'direction': 'rtl'}],                         // text direction

        [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
        [{'header': [1, 2, 3, 4, 5, 6, false]}],

        [{'color': []}, {'background': []}],          // dropdown with defaults from theme
        [{'font': []}],
        [{'align': []}],

        ['clean']                                         // remove formatting button
    ];
    return toolbarOptions;
}

function getJscrollConfigOptions() {
    return {
        autoTrigger: true,
        nextSelector: '.pagination li.active + li a',
        contentSelector: 'div.scrolling-pagination',
        loadingHtml: '<h1 class="loading">Loading...</h1>',
        padding: 0,
        callback: function (data) {
            $('ul.pagination').remove();
        }
    };
}

function initialiseJscroll() {
    $('ul.pagination').hide();
    $('.scrolling-pagination').jscroll(getJscrollConfigOptions());

    $("#post_list").scroll(function () {
        windowScroll()
    })
}

function windowScroll() {
    $('.sidebar').css("position", "fixed")
    $(window).scroll();
}
