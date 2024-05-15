<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered position-relative">
        <div class="modal-content align-items-center">
            <div class="modal-header">
                <h5 class="modal-title " id="logoutModalLabel">Apa anda yakin ingin logout?</h5>
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button position-absolute end-3 top-5"
                    data-bs-dismiss="modal">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="">

                    <a href="{{ route('logout') }}" class="btn bg-gradient-primary">Logout</a>
                </form>
            </div>
        </div>
    </div>
</div>
