<?= $this->include('templates/header'); ?>

<section class="registration-section py-5 min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-5 text-center">
                        <?php if ($type === 'success'): ?>
                            <div class="mb-4">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-check-circle-fill text-success fs-1"></i>
                                </div>
                            </div>
                            <h2 class="display-6 fw-bold mb-3" style="color: #3D204E;"><?= $title ?></h2>
                            <p class="fs-5 text-muted mb-4"><?= $message ?></p>
                            <a href="/login" class="btn btn-lg px-5 py-3 rounded-pill text-white" style="background: #3D204E;">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login Now
                            </a>
                            
                        <?php elseif ($type === 'expired'): ?>
                            <div class="mb-4">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-clock-history text-warning fs-1"></i>
                                </div>
                            </div>
                            <h2 class="display-6 fw-bold mb-3" style="color: #3D204E;"><?= $title ?></h2>
                            <p class="fs-5 text-muted mb-4"><?= $message ?></p>
                            
                            <form id="resendVerificationForm" class="mt-3">
                                <input type="hidden" name="email" value="<?= $email ?>">
                                <button type="submit" class="btn btn-lg px-5 py-3 rounded-pill text-white" style="background: #3D204E;">
                                    <i class="bi bi-envelope-paper me-2"></i>Resend Verification Email
                                </button>
                            </form>
                            
                        <?php else: ?>
                            <div class="mb-4">
                                <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-exclamation-triangle-fill text-danger fs-1"></i>
                                </div>
                            </div>
                            <h2 class="display-6 fw-bold mb-3" style="color: #3D204E;"><?= $title ?></h2>
                            <p class="fs-5 text-muted mb-4"><?= $message ?></p>
                            <a href="/register" class="btn btn-lg px-5 py-3 rounded-pill text-white" style="background: #3D204E;">
                                <i class="bi bi-arrow-left me-2"></i>Back to Registration
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#resendVerificationForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="bi bi-hourglass-split me-2"></i>Sending...');
        
        $.ajax({
            type: 'POST',
            url: '/resend-verification',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Email Sent!',
                        text: response.message,
                        confirmButtonColor: '#3D204E'
                    });
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        confirmButtonColor: '#3D204E'
                    });
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again.',
                    confirmButtonColor: '#3D204E'
                });
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
            }
        });
    });
});
</script>

<?= $this->include('templates/footer'); ?>