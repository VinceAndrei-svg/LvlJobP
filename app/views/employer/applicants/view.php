<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicants for <?= htmlspecialchars($job_posting['job_title']) ?> - JobConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include APP_DIR.'views/employer/sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="bg-white shadow-md">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900">Applicants for <?= htmlspecialchars($job_posting['job_title']) ?></h1>
                    <form action="<?= site_url('employer/applicants/download_all/' . $job_posting['id']) ?>" method="POST">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            Download All Applicants
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-7xl mx-auto">
                    <?php if (empty($applicants)): ?>
                        <p class="text-xl text-gray-600">No applicants yet for this job posting.</p>
                    <?php else: ?>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul class="divide-y divide-gray-200">
                                <?php foreach ($applicants as $applicant): ?>
                                    <li>
                                        <div class="px-4 py-4 sm:px-6 flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($applicant['first_name'] . ' ' . $applicant['last_name']) ?>&background=random" alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?= htmlspecialchars($applicant['first_name'] . ' ' . $applicant['last_name']) ?>
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        <?= htmlspecialchars($applicant['email']) ?>
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        Applied on: <?= date('M d, Y', strtotime($applicant['created_at'])) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex items-center space-x-2">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?= $applicant['status'] === 'pending' ? 'yellow' : ($applicant['status'] === 'reviewed' ? 'blue' : ($applicant['status'] === 'rejected' ? 'red' : 'green')) ?>-100 text-<?= $applicant['status'] === 'pending' ? 'yellow' : ($applicant['status'] === 'reviewed' ? 'blue' : ($applicant['status'] === 'rejected' ? 'red' : 'green')) ?>-800">
                                                    <?= ucfirst($applicant['status']) ?>
                                                </span>
                                                <?php if ($applicant['status'] === 'pending'): ?>
                                                    <form action="<?= site_url('employer/applicants/update_status/' . $applicant['application_id']) ?>" method="POST" class="inline-block">
                                                        <input type="hidden" name="status" value="reviewed">
                                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold py-1 px-2 rounded">
                                                            Review
                                                        </button>
                                                    </form>
                                                    <form action="<?= site_url('employer/applicants/update_status/' . $applicant['application_id']) ?>" method="POST" class="inline-block">
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-1 px-2 rounded">
                                                            Reject
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <button onclick="downloadResume(<?= htmlspecialchars(json_encode($applicant)) ?>)" class="bg-gray-500 hover:bg-gray-600 text-white text-xs font-bold py-1 px-2 rounded">
                                                    Download Resume
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    const sidebar = document.querySelector('.bg-blue-800');
                    sidebar.classList.toggle('-translate-x-full');
                });
            }
        });

        // Function to download resume
        function downloadResume(applicant) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Set font
            doc.setFont("helvetica");

            // Add applicant name
            doc.setFontSize(20);
            doc.text(`${applicant.first_name} ${applicant.last_name}`, 105, 20, null, null, 'center');

            // Add contact information
            doc.setFontSize(12);
            doc.text(`Email: ${applicant.email}`, 20, 40);
            doc.text(`Phone: ${applicant.phone || 'N/A'}`, 20, 50);
            doc.text(`Location: ${applicant.location || 'N/A'}`, 20, 60);
            doc.text(`Date of Birth: ${applicant.date_of_birth || 'N/A'}`, 20, 70);

            let yPos = 90;

            // Add summary
            if (applicant.summary) {
                doc.setFontSize(16);
                doc.text('Summary', 20, yPos);
                doc.setFontSize(12);
                const summaryLines = doc.splitTextToSize(applicant.summary, 170);
                doc.text(summaryLines, 20, yPos + 10);
                yPos += 20 + (summaryLines.length * 5);
            }

            // Add application details
            doc.setFontSize(16);
            doc.text('Application Details', 20, yPos);
            doc.setFontSize(12);
            doc.text(`Status: ${applicant.status}`, 20, yPos + 10);
            doc.text(`Applied on: ${new Date(applicant.created_at).toLocaleDateString()}`, 20, yPos + 20);
            yPos += 40;

            // Add education
            if (applicant.education && applicant.education.length > 0) {
                doc.setFontSize(16);
                doc.text('Education', 20, yPos);
                doc.setFontSize(12);
                yPos += 10;
                applicant.education.forEach(edu => {
                    doc.text(`${edu.degree} - ${edu.institution}`, 20, yPos);
                    doc.text(`Graduation Date: ${edu.graduation_date}`, 20, yPos + 10);
                    yPos += 20;
                });
            }

            // Add work experience
            if (applicant.experience && applicant.experience.length > 0) {
                doc.setFontSize(16);
                doc.text('Work Experience', 20, yPos);
                doc.setFontSize(12);
                yPos += 10;
                applicant.experience.forEach(exp => {
                    doc.text(`${exp.job_title} at ${exp.company}`, 20, yPos);
                    doc.text(`${exp.start_date} - ${exp.end_date}`, 20, yPos + 10);
                    const descLines = doc.splitTextToSize(exp.job_description, 170);
                    doc.text(descLines, 20, yPos + 20);
                    yPos += 30 + (descLines.length * 5);
                });
            }

            // Add certifications
            if (applicant.certifications && applicant.certifications.length > 0) {
                doc.setFontSize(16);
                doc.text('Certifications', 20, yPos);
                doc.setFontSize(12);
                yPos += 10;
                applicant.certifications.forEach(cert => {
                    doc.text(`${cert.certification} - ${cert.issuing_organization}`, 20, yPos);
                    doc.text(`Issue Date: ${cert.issue_date}`, 20, yPos + 10);
                    yPos += 20;
                });
            }

            // Save the PDF
            doc.save(`${applicant.first_name}_${applicant.last_name}_resume.pdf`);
        }
    </script>
</body>
</html>

