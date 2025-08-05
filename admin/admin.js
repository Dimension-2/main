    // Remove duplicate document.ready and fix closing braces
    $(document).ready(function () {
        // Image Preview Handler (jQuery version)
        $('#mediaFile').on('change', function (e) {
            const preview = $('#imagePreview');
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.attr('src', e.target.result).show();
                }

                reader.readAsDataURL(file);
            } else {
                preview.hide();
            }
        });

        // Media Edit Handler
        $(document).on('click', '.edit-media', function (e) {
            e.preventDefault();
            const mediaId = $(this).data('id');

            $.ajax({
                url: 'get_media.php',
                type: 'GET',
                data: { id: mediaId },
                dataType: 'json',
                success: function (response) {
                    // Set common form values
                    $('#mediaId').val(response.id);
                    $('#contentType').val(response.content_type);
                    $('#mediaSection').val(response.section);
                    $('#mediaDescription').val(response.description);

                    // Handle different content types
                    switch (response.content_type) {
                        case 'image':
                            $('#fileUploadGroup, #altTextGroup').show();
                            $('#contentTextGroup').hide();
                            $('#mediaAltText').val(response.alt_text || '');
                            $('#currentFile').html(
                                response.file_path
                                    ? `Current file: <a href="../${response.file_path}" target="_blank">View</a> | 
                               <a href="#" class="remove-file" data-id="${response.id}">Remove</a>`
                                    : 'No file uploaded'
                            );
                            break;

                        case 'video':
                            $('#fileUploadGroup').show();
                            $('#altTextGroup, #contentTextGroup').hide();
                            $('#currentFile').html(
                                response.file_path
                                    ? `Current file: <a href="../${response.file_path}" target="_blank">View</a>`
                                    : 'No file uploaded'
                            );
                            break;

                        case 'text':
                            $('#fileUploadGroup, #altTextGroup').hide();
                            $('#contentTextGroup').show();
                            $('#mediaContentText').val(response.content_text || '');
                            break;

                        default:
                            console.warn('Unknown content type:', response.content_type);
                            $('#fileUploadGroup, #altTextGroup, #contentTextGroup').hide();
                    }

                    $('#editMediaModal').modal('show');
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                    alert("Failed to load media data");
                }
            });
        });

        // Form Submission Handler
        $('#mediaForm').off('submit').on('submit', function (e) {
            e.preventDefault();
            const submitBtn = $(this).find('[type="submit"]');
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

            // File validation - NEW VERSION
            // File validation - Unlimited version (improved)
            // File validation - All inclusive version
            const file = $('#mediaFile')[0].files[0];
            if (file) {
                // Basic check for image or video files
                if (!file.type.match(/^(image|video|application)\//)) {
                    alert('Please select an image or video file');
                    submitBtn.prop('disabled', false).html('Save Changes');
                    return;
                }
            }


            $.ajax({
                url: 'update_media.php',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#editMediaModal').modal('hide');
                    location.reload();
                },
                error: function (xhr) {
                    alert("Error: " + xhr.responseText);
                },
                complete: function () {
                    submitBtn.prop('disabled', false).html('Save Changes');
                }
            });
        });

        // File Removal Handler
        $(document).on('click', '.remove-file', function (e) {
            e.preventDefault();
            if (confirm('Remove this file?')) {
                const mediaId = $(this).data('id');
                $.post('remove_file.php', { id: mediaId }, function () {
                    $('#editMediaModal').modal('hide');
                    location.reload();
                });
            }
        });
    });