function deletePost(templateId) {
    'use strict';

    if (confirm("Are you sure you want to delete this template?")) {
        document.getElementById(`delete_${templateId}`).submit();
    }
}