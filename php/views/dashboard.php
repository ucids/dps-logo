<script>
    var isEdit = false; // Flag to identify whether the operation is an edit
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es', // Set the locale to Spanish
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: 'app/meetings.php',
            displayEventEnd: true,
            eventOverlap: false,
            eventTimeFormat: { // like '14:30'
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false
            },
            eventColor: event => event.color,
            dateClick: function (info) {
                // Show the modal when a date is clicked
                // $('input[name="calendar_event_start_date"]').val(info.dateStr);
                $('#date').val(info.dateStr);
                $('#label_date').text(info.dateStr);
                $('#eventModal').modal('show');
            },
            eventClick: function (info) {
                // Store the clicked event in a variable
                var currentEvent = info.event;
                // Populate the modal with the current event data
                $('[data-kt-calendar="meeting_id"]').val(currentEvent.id);
                $('[data-kt-calendar="event_name"]').text(currentEvent.title);
                $('[data-kt-calendar="event_description"]').text(currentEvent.extendedProps.description);
                $('[data-kt-calendar="event_location"]').text(currentEvent.extendedProps.location);
                $('[data-kt-calendar="event_start_date"]').text(currentEvent.start.toLocaleDateString());
                $('[data-kt-calendar="event_end_date"]').text(currentEvent.end.toLocaleDateString());
                // Show the modal
                $('#eventModalinfo').modal('show');

                // Add click event handler for the "Edit" button
                $('#kt_modal_view_event_edit').off('click').on('click', function () {
                    isEdit = true; // Set the flag to true
                    // Populate the form with the current event's data
                    $('input[name="meeting_id"]').val(currentEvent.id);
                    $('input[name="calendar_event_name"]').val(currentEvent.title);
                    $('input[name="calendar_event_description"]').val(currentEvent.extendedProps.description);
                    $('input[name="calendar_event_location"]').val(currentEvent.extendedProps.location);
                    $('input[name="calendar_event_start_date"]').val(currentEvent.start.toLocaleDateString());
                    $('input[name="calendar_event_end_date"]').val(currentEvent.end.toLocaleDateString());
                    $('input[name="users"]').val(currentEvent.extendedProps.users_invited.map(user => user.name).join(', '));
                    $('input[name="motivo"]').val(currentEvent.extendedProps.motivo);
                    
                    // $('select[name="sala"]').val(currentEvent.extendedProps.sala).trigger('change');
                    // Show the form
                    $('#eventModal').modal('show');
                    $('#eventModalinfo').modal('hide');
                    // clear all inputs at hide modal

                });
                $('#eventModal').on('hidden.bs.modal', function () {
                    // Clear all input fields in the modal
                    $(this).find('input').val('');
                });
            }
        });
        calendar.render();
        setInterval(function () {
            calendar.refetchEvents();
        }, 5000);
    });
</script>
<div id='calendar'></div>

<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#" id="kt_modal_add_event_form">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold" data-kt-calendar="title">Agregar un Evento Nuevo</h2>
                    <label id="label_date" class="fs-6 fw-semibold required mb-2"></label>
                    <input type="hidden" name="meeting_id" data-kt-calendar="meeting_id">
                    <input type="hidden" id="date" name="date">
                    <input type="hidden" name="user_id" value="<?=$_SESSION['id']?>">
                    <!--end::Modal title-->

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" id="kt_modal_add_event_close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Input group-->
                    <div class="fv-row mb-9 fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold required mb-2">Sala</label>
                        <!--end::Label-->
                        <!-- <input type="text" id="kt_datepicker_start"> -->
                        <!--begin::Input-->
                        <!-- <input type="text" class="form-control form-control-solid" placeholder=""
                            name="calendar_event_name" value=""> -->
                        <!-- <select class="form-select form-select-solid" data-control="select2"
                            data-dropdown-css-class="w-200px" data-placeholder="Selecciona una Opción"
                            data-hide-search="true" name="sala">
                            <option></option>
                            <option value="1">Sala 1</option>
                            <option value="2">Sala 2</option>
                        </select> -->
                        <select class="form-select" data-placeholder="Selecciona una Sala" name="sala">
                            <option value="1">Sala 1</option>
                            <option value="2">Sala 2</option>
                        </select>
                        <!--end::Input-->
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">Asistentes</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input class="form-control d-flex align-items-center" value="" placeholder="Invitar Usuarios"
                            id="kt_tagify_users" name="users" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">Motivo</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" placeholder=""
                            name="motivo">
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row row-cols-lg-2 g-10">
                        <div class="col">
                            <div class="fv-row mb-9 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2 required">Hora de Inicio</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid flatpickr-input"
                                    name="calendar_event_start_date" placeholder="Pick a start date"
                                    id="kt_datepicker_start" type="text" data-input>
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-9 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2 required">Hora de Finalizacón</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input class="form-control form-control-solid flatpickr-input"
                                    name="calendar_event_end_date" placeholder="Pick a end date" id="kt_datepicker_end"
                                    type="text" value="">
                                <!--end::Input-->
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="col d-none" data-kt-calendar="datepicker">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">Event End Time</label>
                                <!--end::Label-->
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row row-cols-lg-2 g-10">

                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_event_cancel" class="btn btn-light me-3">
                        Cancel
                    </button>
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="button" id="kt_modal_add_event_submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Submit
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="eventModalinfo" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header border-0 justify-content-end">
                <!--begin::Edit-->
                <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary me-2"
                    data-bs-toggle="tooltip" data-bs-dismiss="click" id="kt_modal_view_event_edit"
                    aria-label="Edit Event" data-bs-original-title="Edit Event" data-kt-initialized="1">
                    <i class="ki-outline ki-pencil fs-2"></i>
                </div>
                <!--end::Edit-->

                <!--begin::Edit-->
                <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-danger me-2" data-bs-toggle="tooltip"
                    data-bs-dismiss="click" id="kt_modal_view_event_delete" aria-label="Delete Event"
                    data-bs-original-title="Delete Event" data-kt-initialized="1">
                    <i class="ki-outline ki-trash fs-2"></i>
                </div>
                <!--end::Edit-->

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary" data-bs-toggle="tooltip"
                    data-bs-dismiss="click" id="kt_edit_hide" aria-label="Hide Event"
                    data-bs-original-title="Hide Event" data-kt-initialized="1">
                    <i class="ki-outline ki-cross fs-2x"></i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body pt-0 pb-20 px-lg-17">
                <!--begin::Row-->
                <div class="d-flex">
                    <!--begin::Icon-->
                    <i class="ki-outline ki-calendar-8 fs-1 text-muted me-5"></i> <!--end::Icon-->

                    <div class="mb-9">
                        <!--begin::Event name-->
                        <div class="d-flex align-items-center mb-2">
                            <span class="fs-3 fw-bold me-3" data-kt-calendar="event_name">Conference</span> <span
                                class="badge badge-light-success" data-kt-calendar="all_day">All Day</span>
                        </div>
                        <!--end::Event name-->

                        <!--begin::Event description-->
                        <div class="fs-6" data-kt-calendar="event_description">Lorem ipsum dolor eius mod tempor labore
                        </div>
                        <!--end::Event description-->
                    </div>
                </div>
                <!--end::Row-->

                <!--begin::Row-->
                <div class="d-flex align-items-center mb-2">
                    <!--begin::Bullet-->
                    <span class="bullet bullet-dot h-10px w-10px bg-success ms-2 me-7"></span>
                    <!--end::Bullet-->

                    <!--begin::Event start date/time-->
                    <div class="fs-6"><span class="fw-bold">Starts</span> <span data-kt-calendar="event_start_date">14th
                            Mar,
                            2024</span></div>
                    <!--end::Event start date/time-->
                </div>
                <!--end::Row-->

                <!--begin::Row-->
                <div class="d-flex align-items-center mb-9">
                    <!--begin::Bullet-->
                    <span class="bullet bullet-dot h-10px w-10px bg-danger ms-2 me-7"></span>
                    <!--end::Bullet-->

                    <!--begin::Event end date/time-->
                    <div class="fs-6"><span class="fw-bold">Ends</span> <span data-kt-calendar="event_end_date">16th
                            Mar,
                            2024</span></div>
                    <!--end::Event end date/time-->
                </div>
                <!--end::Row-->

                <!--begin::Row-->
                <div class="d-flex align-items-center">
                    <!--begin::Icon-->
                    <i class="ki-outline ki-geolocation fs-1 text-muted me-5"></i> <!--end::Icon-->

                    <!--begin::Event location-->
                    <div class="fs-6" data-kt-calendar="event_location">Conference Hall A</div>
                    <!--end::Event location-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Modal body-->
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $("#kt_datepicker_start").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            allowInput: true,
        });
        $("#kt_datepicker_end").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K",
            allowInput: true,
        });
        // Hide the modal when the "Cancel" button is clicked
        $('#kt_modal_add_event_cancel').click(function () {
            $('#eventModal').modal('hide');
        });
        $('#kt_modal_add_event_close').click(function () {
            $('#eventModal').modal('hide');
        });
        $('#eventModalinfo').click(function () {
            $('#eventModalinfo').modal('hide');
        });
    });
</script>

<script>
    var inputElm = document.querySelector('#kt_tagify_users');
    var tagify;  // Declare tagify here
    fetch('app/users.php')
        .then(response => response.json())
        .then(usersList => {
            console.log(usersList);  // Log the data to the console
            // Assign to tagify here, after usersList has been populated
            tagify = new Tagify(inputElm, {
                tagTextProp: 'name',
                enforceWhitelist: true,
                skipInvalid: true,
                dropdown: {
                    closeOnSelect: false,
                    enabled: 0,
                    classname: 'users-list',
                    searchKeys: ['name', 'email']
                },
                templates: {
                    tag: tagTemplate,
                    dropdownItem: suggestionItemTemplate
                },
                whitelist: usersList
            });

            tagify.on('dropdown:show dropdown:updated', onDropdownShow);
            tagify.on('dropdown:select', onSelectSuggestion);
        })
        .catch((error) => console.error('Error:', error));

    function tagTemplate(tagData) {
        return `
        <tag title="${(tagData.title || tagData.email)}"
                contenteditable='false'
                spellcheck='false'
                tabIndex="-1"
                class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ""}"
                ${this.getAttributes(tagData)}>
            <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div class="d-flex align-items-center">
                <div class='tagify__tag__avatar-wrap ps-0'>
                    <img onerror="this.style.visibility='hidden'" class="rounded-circle w-25px me-2" src="assets/media/${tagData.avatar}">
                </div>
                <span class='tagify__tag-text'>${tagData.name}</span>
            </div>
        </tag>
    `
    }

    function suggestionItemTemplate(tagData) {
        return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item d-flex align-items-center ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">

            ${tagData.avatar ? `
                    <div class='tagify__dropdown__item__avatar-wrap me-2'>
                        <img onerror="this.style.visibility='hidden'"  class="rounded-circle w-50px me-2" src="assets/media/${tagData.avatar}">
                    </div>` : ''
            }

            <div class="d-flex flex-column">
                <strong>${tagData.name}</strong>
                <span>${tagData.email}</span>
            </div>
        </div>
    `
    }
    var addAllSuggestionsElm;

    function onDropdownShow(e) {
        var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;

        if (tagify.suggestedListItems.length > 1) {
            addAllSuggestionsElm = getAddAllSuggestionsElm();

            // insert "addAllSuggestionsElm" as the first element in the suggestions list
            dropdownContentElm.insertBefore(addAllSuggestionsElm, dropdownContentElm.firstChild)
        }
    }

    function onSelectSuggestion(e) {
        if (e.detail.elm == addAllSuggestionsElm)
            tagify.dropdown.selectAll.call(tagify);
    }

    // create a "add all" custom suggestion element every time the dropdown changes
    function getAddAllSuggestionsElm() {
        // suggestions items should be based on "dropdownItem" template
        return tagify.parseTemplate('dropdownItem', [{
            class: "addAll",
            name: "Add all",
            email: tagify.settings.whitelist.reduce(function (remainingSuggestions, item) {
                return tagify.isTagDuplicate(item.value) ? remainingSuggestions : remainingSuggestions + 1
            }, 0) + " Members"
        }]
        )
    }
</script>

<script>
    $('#kt_modal_add_event_submit').click(function(event) {
        event.preventDefault(); // Prevent the form from submitting via the browser
        var formData = $('#kt_modal_add_event_form').serialize(); // Serialize the form data

        // Send the form data to the server
        $.ajax({
            type: 'POST',
            url: isEdit ? 'app/edit_meeting.php' : 'app/create_meeting.php',
            data: formData,
            beforeSend: function() {
                // Show the loading indicator
                $('#kt_modal_add_event_submit .indicator-label').hide();
                $('#kt_modal_add_event_submit .indicator-progress').show();
            },
            success: function(response) {
                // Parse the JSON response
                var jsonResponse = JSON.parse(response);

                // Hide the loading indicator
                $('#kt_modal_add_event_submit .indicator-label').show();
                $('#kt_modal_add_event_submit .indicator-progress').hide();

                if (jsonResponse.status === 'success') {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Meeting created successfully',
                        confirmButtonText: 'OK'
                    });

                    // Close the modal
                    $('#eventModal').modal('hide');
                } else if (jsonResponse.status === 'error') {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: jsonResponse.message,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle any errors
                console.error(textStatus, errorThrown);

                // Hide the loading indicator
                $('#kt_modal_add_event_submit .indicator-label').show();
                $('#kt_modal_add_event_submit .indicator-progress').hide();
            }
        });
    });
</script>