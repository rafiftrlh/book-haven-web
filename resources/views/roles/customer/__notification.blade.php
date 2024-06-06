<div class="container-fluid py-4">
    <h4>Notification</h4>

    <div class="bgnotif rounded shadow py-4">
        @foreach ($notifications as $notification)
            <div id="notif-{{ $notification->id }}" class="notif bg-gray w-90 ms-5 mt-4 rounded-1 border border-2 border-dark me-5 p-3 d-flex align-items-start" style="min-height: 85px;">
                <div id="circle-{{ $notification->id }}" class="rounded-circle {{ $notification->is_read ? 'bg-info' : 'bg-primary' }}" style="width: 25px; height: 20px; top: -25px; left: -25px; position:relative;"></div>
            
                <span class="text-bold fs-6 ms-2 text-break mt-3" style="flex-grow: 1;">{{ $notification->message }}</span>

                <!-- Read Button -->
                <button type="button" class="btn btn-primary me-3 mt-3" data-bs-toggle="modal" data-bs-target="#readModal-{{ $notification->id }}">Read</button>

                <!-- Delete Form -->
                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>

            <!-- Modal for Read -->
            <div class="modal fade" id="readModal-{{ $notification->id }}" tabindex="-1" aria-labelledby="readModalLabel-{{ $notification->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="readModalLabel-{{ $notification->id }}">Notification Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{ $notification->message }}
                        </div>
                        <div class="modal-footer">
                            <!-- Form to mark as read -->
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="mark-as-read-form">
                                @csrf
                                <button type="submit" class="btn btn-secondary">Close</button>
                            </form>
                           
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .text-break {
        word-break: break-word;
    }
    .bg-info {
        background-color: #17a2b8 !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    // Function to mark notification as read
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                document.getElementById(`circle-${notificationId}`).classList.remove('bg-primary');
                document.getElementById(`circle-${notificationId}`).classList.add('bg-info');
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    }

    // Attach event listeners to modals
    document.querySelectorAll('.modal').forEach(modal => {
        const modalId = modal.getAttribute('id');
        const notificationId = modalId.split('-')[1];

        // When modal is hidden
        modal.addEventListener('hidden.bs.modal', function (event) {
            markAsRead(notificationId);
        });

        // When "Mark as Read" button is clicked
        modal.querySelector('.mark-as-read-form').addEventListener('submit', function (event) {
            event.preventDefault();
            markAsRead(notificationId);
        });
    });
});
</script>
