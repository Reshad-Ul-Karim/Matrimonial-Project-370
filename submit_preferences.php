<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Include the database connection file
include('DBconnect.php');

// Collect filter settings from POST or initialize them
$filters = [
    'profession' => $_POST['profession'] ?? '',
    'gender' => $_POST['gender'] ?? '',
    'religion' => $_POST['religion'] ?? '',
    'ethnicity' => $_POST['ethnicity'] ?? '',
    'marital_status' => $_POST['marital_status'] ?? '',
    'secondary_education' => $_POST['secondary_education'] ?? '',
    'higher_secondary' => $_POST['higher_secondary'] ?? '',
    'undergrade' => $_POST['undergrade'] ?? '',
    'post_grade' => $_POST['post_grade'] ?? '',
    'complexion' => $_POST['complexion'] ?? '',
    'height' => $_POST['height'] ?? '',
    'min_age' => $_POST['min_age'] ?? '',
    'max_age' => $_POST['max_age'] ?? ''
];

// Construct SQL query based on the filters
$sql = "SELECT User.*, Profile_Details.* FROM User
        JOIN Profile_Details ON User.user_id = Profile_Details.user_id
        WHERE 1=1";

foreach ($filters as $key => $value) {
    if (!empty($value)) {
        if ($key === 'height') {
            $sql .= " AND Height = " . floatval($value);
        } elseif ($key === 'min_age') {
            $minDate = date('Y-m-d', strtotime(date('Y-m-d') . ' -' . intval($value) . ' years'));
            $sql .= " AND DOB <= '" . $minDate . "'";
        } elseif ($key === 'max_age') {
            $maxDate = date('Y-m-d', strtotime(date('Y-m-d') . ' -' . intval($value) . ' years'));
            $sql .= " AND DOB >= '" . $maxDate . "'";
        } else {
            $sql .= " AND $key = '" . $conn->real_escape_string($value) . "'";
        }
    }
}

// Execute query and fetch results
$result = $conn->query($sql);

// Start HTML
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matching Profiles</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Product+Sans&display=swap');

        body {
            font-family: 'Product Sans', Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }

        header {
            background: linear-gradient(90deg, #f7886cd6 0%, rgba(255, 42, 0, 0.784) 100%);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            flex-wrap: wrap; /* Ensure proper wrapping on smaller screens */
            text-align: center;
            position: relative;
        }

        header img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .header-right {
            display: flex;
            gap: 20px;
        }

        .header-right a {
            background-color: #f76c6c;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }

        .header-right a:hover {
            background-color: #ff9999;
        }

        .container {
            display: flex;
            height: 100vh;
            overflow-y: hidden;
        }

        /* Sidebar styling */
        .sidebar {
            width: 300px;
            background-color: #ffe4e1;
            padding: 20px;
            border-right: 2px solid #f76c6c;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar h2 {
            text-align: center;
            color: #f76c6c;
            margin-bottom: 20px;
        }

        .sidebar form label {
            font-weight: bold;
            color: #f76c6c;
            margin-bottom: 5px;
        }

        .sidebar form input,
        .sidebar form select,
        .sidebar form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #f76c6c;
        }

        .sidebar form button {
            background-color: #f76c6c;
            color: white;
            cursor: pointer;
        }

        .sidebar form button:hover {
            background-color: #ff9999;
        }

        /* Main content styling */
        .main-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }

        h2 {
            text-align: center;
            color: #f76c6c;
            margin-top: 20px;
        }

        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffe4e1;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            border: 2px solid #f76c6c;
        }

        .profile {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.5s ease;
        }

        .profile img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }

        .profile-info {
            flex: 1;
        }

        .profile-info h3 {
            margin: 0;
            color: #f76c6c;
        }

        .profile-info p {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }

        .match-percentage {
            font-size: 18px;
            font-weight: bold;
            color: #f76c6c;
        }

        .profile-actions {
            text-align: right;
        }

        .profile-actions button {
            background-color: #f76c6c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .profile-actions button:hover {
            background-color: #ff9999;
        }

        /* Scrollbar styling for sidebar and profile-container */
        .sidebar::-webkit-scrollbar,
        .profile-container::-webkit-scrollbar {
            width: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb,
        .profile-container::-webkit-scrollbar-thumb {
            background-color: #f76c6c;
            border-radius: 5px;
        }

        .sidebar::-webkit-scrollbar-track,
        .profile-container::-webkit-scrollbar-track {
            background-color: #f0f8ff;
        }
    </style>
</head>

<body>

    <header>
        <img src="icon.png" alt="Logo">
        <h1>Matrimonial Hub</h1>
        <div class="header-right">
            <a href="home.php">Home</a>
            <a href="submit_preferences.php">Set Preferences</a>
        </div>
    </header>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Filter Users</h2>
            <form method="POST" action="">
        	<!-- Profession -->
                <label for="profession">Profession:</label>
                <select name="profession">
                    <option value="">Select Profession</option>
                    
                    <optgroup label="Technology and IT">
                        <option value="software-engineer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'software-engineer') ? 'selected' : ''; ?>>Software Engineer</option>
                        <option value="data-scientist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'data-scientist') ? 'selected' : ''; ?>>Data Scientist</option>
                        <option value="it-support-specialist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'it-support-specialist') ? 'selected' : ''; ?>>IT Support Specialist</option>
                        <option value="web-developer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'web-developer') ? 'selected' : ''; ?>>Web Developer</option>
                        <option value="cybersecurity-analyst" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'cybersecurity-analyst') ? 'selected' : ''; ?>>Cybersecurity Analyst</option>
                        <option value="cloud-engineer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'cloud-engineer') ? 'selected' : ''; ?>>Cloud Engineer</option>
                        <option value="network-administrator" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'network-administrator') ? 'selected' : ''; ?>>Network Administrator</option>
                        <option value="mobile-app-developer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'mobile-app-developer') ? 'selected' : ''; ?>>Mobile App Developer</option>
                        <option value="ux-ui-designer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'ux-ui-designer') ? 'selected' : ''; ?>>UX/UI Designer</option>
                        <option value="blockchain-developer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'blockchain-developer') ? 'selected' : ''; ?>>Blockchain Developer</option>
                        <option value="ai-engineer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'ai-engineer') ? 'selected' : ''; ?>>Artificial Intelligence Engineer</option>
                        <option value="game-developer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'game-developer') ? 'selected' : ''; ?>>Game Developer</option>
                    </optgroup>

                    <optgroup label="Healthcare and Medicine">
                        <option value="doctor" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'doctor') ? 'selected' : ''; ?>>Doctor/Physician</option>
                        <option value="nurse" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'nurse') ? 'selected' : ''; ?>>Nurse</option>
                        <option value="dentist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'dentist') ? 'selected' : ''; ?>>Dentist</option>
                        <option value="pharmacist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'pharmacist') ? 'selected' : ''; ?>>Pharmacist</option>
                        <option value="physical-therapist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'physical-therapist') ? 'selected' : ''; ?>>Physical Therapist</option>
                        <option value="psychologist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'psychologist') ? 'selected' : ''; ?>>Psychologist</option>
                        <option value="medical-research-scientist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'medical-research-scientist') ? 'selected' : ''; ?>>Medical Research Scientist</option>
                        <option value="occupational-therapist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'occupational-therapist') ? 'selected' : ''; ?>>Occupational Therapist</option>
                        <option value="radiologist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'radiologist') ? 'selected' : ''; ?>>Radiologist</option>
                        <option value="paramedic" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'paramedic') ? 'selected' : ''; ?>>Paramedic</option>
                        <option value="optometrist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'optometrist') ? 'selected' : ''; ?>>Optometrist</option>
                        <option value="veterinarian" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'veterinarian') ? 'selected' : ''; ?>>Veterinarian</option>
                    </optgroup>

                    <optgroup label="Engineering and Architecture">
                        <option value="civil-engineer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'civil-engineer') ? 'selected' : ''; ?>>Civil Engineer</option>
                        <option value="mechanical-engineer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'mechanical-engineer') ? 'selected' : ''; ?>>Mechanical Engineer</option>
                        <option value="electrical-engineer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'electrical-engineer') ? 'selected' : ''; ?>>Electrical Engineer</option>
                        <option value="chemical-engineer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'chemical-engineer') ? 'selected' : ''; ?>>Chemical Engineer</option>
                        <option value="aerospace-engineer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'aerospace-engineer') ? 'selected' : ''; ?>>Aerospace Engineer</option>
                        <option value="environmental-engineer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'environmental-engineer') ? 'selected' : ''; ?>>Environmental Engineer</option>
                        <option value="biomedical-engineer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'biomedical-engineer') ? 'selected' : ''; ?>>Biomedical Engineer</option>
                        <option value="industrial-engineer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'industrial-engineer') ? 'selected' : ''; ?>>Industrial Engineer</option>
                        <option value="architect" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'architect') ? 'selected' : ''; ?>>Architect</option>
                        <option value="urban-planner" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'urban-planner') ? 'selected' : ''; ?>>Urban Planner</option>
                        <option value="structural-engineer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'structural-engineer') ? 'selected' : ''; ?>>Structural Engineer</option>
                    </optgroup>

                    <optgroup label="Business and Finance">
                        <option value="accountant" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'accountant') ? 'selected' : ''; ?>>Accountant</option>
                        <option value="financial-analyst" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'financial-analyst') ? 'selected' : ''; ?>>Financial Analyst</option>
                        <option value="investment-banker" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'investment-banker') ? 'selected' : ''; ?>>Investment Banker</option>
                        <option value="hr-manager" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'hr-manager') ? 'selected' : ''; ?>>Human Resources Manager</option>
                        <option value="marketing-manager" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'marketing-manager') ? 'selected' : ''; ?>>Marketing Manager</option>
                        <option value="sales-manager" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'sales-manager') ? 'selected' : ''; ?>>Sales Manager</option>
                        <option value="business-consultant" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'business-consultant') ? 'selected' : ''; ?>>Business Consultant</option>
                        <option value="project-manager" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'project-manager') ? 'selected' : ''; ?>>Project Manager</option>
                        <option value="entrepreneur" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'entrepreneur') ? 'selected' : ''; ?>>Entrepreneur</option>
                        <option value="economist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'economist') ? 'selected' : ''; ?>>Economist</option>
                        <option value="real-estate-agent" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'real-estate-agent') ? 'selected' : ''; ?>>Real Estate Agent</option>
                        <option value="operations-manager" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'operations-manager') ? 'selected' : ''; ?>>Operations Manager</option>
                    </optgroup>

                    <optgroup label="Creative Arts and Design">
                        <option value="graphic-designer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'graphic-designer') ? 'selected' : ''; ?>>Graphic Designer</option>
                        <option value="interior-designer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'interior-designer') ? 'selected' : ''; ?>>Interior Designer</option>
                        <option value="fashion-designer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'fashion-designer') ? 'selected' : ''; ?>>Fashion Designer</option>
                        <option value="photographer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'photographer') ? 'selected' : ''; ?>>Photographer</option>
                        <option value="animator" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'animator') ? 'selected' : ''; ?>>Animator</option>
                        <option value="art-director" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'art-director') ? 'selected' : ''; ?>>Art Director</option>
                        <option value="copywriter" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'copywriter') ? 'selected' : ''; ?>>Copywriter</option>
                        <option value="music-producer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'music-producer') ? 'selected' : ''; ?>>Music Producer</option>
                        <option value="video-editor" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'video-editor') ? 'selected' : ''; ?>>Video Editor</option>
                        <option value="game-designer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'game-designer') ? 'selected' : ''; ?>>Game Designer</option>
                        <option value="illustrator" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'illustrator') ? 'selected' : ''; ?>>Illustrator</option>
                    </optgroup>

                    <optgroup label="Law and Public Services">
                        <option value="lawyer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'lawyer') ? 'selected' : ''; ?>>Lawyer</option>
                        <option value="paralegal" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'paralegal') ? 'selected' : ''; ?>>Paralegal</option>
                        <option value="judge" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'judge') ? 'selected' : ''; ?>>Judge</option>
                        <option value="police-officer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'police-officer') ? 'selected' : ''; ?>>Police Officer</option>
                        <option value="firefighter" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'firefighter') ? 'selected' : ''; ?>>Firefighter</option>
                        <option value="social-worker" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'social-worker') ? 'selected' : ''; ?>>Social Worker</option>
                        <option value="politician" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'politician') ? 'selected' : ''; ?>>Politician</option>
                        <option value="diplomat" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'diplomat') ? 'selected' : ''; ?>>Diplomat</option>
                        <option value="public-relations-specialist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'public-relations-specialist') ? 'selected' : ''; ?>>Public Relations Specialist</option>
                        <option value="probation-officer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'probation-officer') ? 'selected' : ''; ?>>Probation Officer</option>
                    </optgroup>
                    
                    <optgroup label="Science and Research">
                        <option value="biologist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'biologist') ? 'selected' : ''; ?>>Biologist</option>
                        <option value="chemist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'chemist') ? 'selected' : ''; ?>>Chemist</option>
                        <option value="physicist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'physicist') ? 'selected' : ''; ?>>Physicist</option>
                        <option value="environmental-scientist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'environmental-scientist') ? 'selected' : ''; ?>>Environmental Scientist</option>
                        <option value="geologist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'geologist') ? 'selected' : ''; ?>>Geologist</option>
                        <option value="astronomer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'astronomer') ? 'selected' : ''; ?>>Astronomer</option>
                        <option value="forensic-scientist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'forensic-scientist') ? 'selected' : ''; ?>>Forensic Scientist</option>
                        <option value="marine-biologist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'marine-biologist') ? 'selected' : ''; ?>>Marine Biologist</option>
                        <option value="meteorologist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'meteorologist') ? 'selected' : ''; ?>>Meteorologist</option>
                        <option value="geneticist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'geneticist') ? 'selected' : ''; ?>>Geneticist</option>
                    </optgroup>

                    <optgroup label="Trades and Skilled Labor">
                        <option value="electrician" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'electrician') ? 'selected' : ''; ?>>Electrician</option>
                        <option value="plumber" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'plumber') ? 'selected' : ''; ?>>Plumber</option>
                        <option value="carpenter" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'carpenter') ? 'selected' : ''; ?>>Carpenter</option>
                        <option value="mechanic" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'mechanic') ? 'selected' : ''; ?>>Mechanic</option>
                        <option value="welder" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'welder') ? 'selected' : ''; ?>>Welder</option>
                        <option value="hvac-technician" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'hvac-technician') ? 'selected' : ''; ?>>HVAC Technician</option>
                        <option value="truck-driver" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'truck-driver') ? 'selected' : ''; ?>>Truck Driver</option>
                        <option value="construction-worker" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'construction-worker') ? 'selected' : ''; ?>>Construction Worker</option>
                        <option value="landscaper" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'landscaper') ? 'selected' : ''; ?>>Landscaper</option>
                        <option value="painter" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'painter') ? 'selected' : ''; ?>>Painter</option>
                    </optgroup>

                    <optgroup label="Hospitality and Tourism">
                        <option value="hotel-manager" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'hotel-manager') ? 'selected' : ''; ?>>Hotel Manager</option>
                        <option value="travel-agent" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'travel-agent') ? 'selected' : ''; ?>>Travel Agent</option>
                        <option value="chef" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'chef') ? 'selected' : ''; ?>>Chef</option>
                        <option value="event-planner" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'event-planner') ? 'selected' : ''; ?>>Event Planner</option>
                        <option value="flight-attendant" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'flight-attendant') ? 'selected' : ''; ?>>Flight Attendant</option>
                        <option value="tour-guide" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'tour-guide') ? 'selected' : ''; ?>>Tour Guide</option>
                        <option value="restaurant-manager" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'restaurant-manager') ? 'selected' : ''; ?>>Restaurant Manager</option>
                        <option value="cruise-director" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'cruise-director') ? 'selected' : ''; ?>>Cruise Director</option>
                    </optgroup>

                    <optgroup label="Freelance and Remote Work">
                        <option value="virtual-assistant" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'virtual-assistant') ? 'selected' : ''; ?>>Virtual Assistant</option>
                        <option value="freelance-writer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'freelance-writer') ? 'selected' : ''; ?>>Freelance Writer</option>
                        <option value="freelance-graphic-designer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'freelance-graphic-designer') ? 'selected' : ''; ?>>Freelance Graphic Designer</option>
                        <option value="online-tutor" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'online-tutor') ? 'selected' : ''; ?>>Online Tutor</option>
                        <option value="digital-marketing-consultant" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'digital-marketing-consultant') ? 'selected' : ''; ?>>Digital Marketing Consultant</option>
                        <option value="e-commerce-specialist" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'e-commerce-specialist') ? 'selected' : ''; ?>>E-commerce Specialist</option>
                        <option value="freelance-software-developer" <?php echo (isset($_POST['profession']) && $_POST['profession'] == 'freelance-software-developer') ? 'selected' : ''; ?>>Freelance Software Developer</option>
                    </optgroup>

                </select>


                <!-- Gender -->
                <label for="gender">Gender:</label>
                <select name="gender">
                    <option value="">Select Gender</option>
                    <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>

                <!-- Religion -->
                <label for="religion">Religion:</label>
                <select name="religion">
                    <option value="">Select Religion</option>
                    <option value="Muslim" <?php echo (isset($_POST['religion']) && $_POST['religion'] == 'Muslim') ? 'selected' : ''; ?>>Muslim</option>
                    <option value="Hindu" <?php echo (isset($_POST['religion']) && $_POST['religion'] == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                    <option value="Christian" <?php echo (isset($_POST['religion']) && $_POST['religion'] == 'Christian') ? 'selected' : ''; ?>>Christian</option>
                    <option value="Buddhist" <?php echo (isset($_POST['religion']) && $_POST['religion'] == 'Buddhist') ? 'selected' : ''; ?>>Buddhist</option>
                </select>

                <!-- Ethnicity -->
                <label for="ethnicity">Ethnicity:</label>
                <select name="ethnicity">
                    <option value="">Select Ethnicity</option>
                    <option value="Caucasian" <?php echo (isset($_POST['ethnicity']) && $_POST['ethnicity'] == 'Caucasian') ? 'selected' : ''; ?>>Caucasian</option>
                    <option value="African" <?php echo (isset($_POST['ethnicity']) && $_POST['ethnicity'] == 'African') ? 'selected' : ''; ?>>African</option>
                    <option value="Asian" <?php echo (isset($_POST['ethnicity']) && $_POST['ethnicity'] == 'Asian') ? 'selected' : ''; ?>>Asian</option>
                    <option value="Hispanic" <?php echo (isset($_POST['ethnicity']) && $_POST['ethnicity'] == 'Hispanic') ? 'selected' : ''; ?>>Hispanic</option>
                    <option value="Middle Eastern" <?php echo (isset($_POST['ethnicity']) && $_POST['ethnicity'] == 'Middle Eastern') ? 'selected' : ''; ?>>Middle Eastern</option>
                </select>

                <!-- Marital Status -->
                <label for="marital_status">Marital Status:</label>
                <select name="marital_status">
                    <option value="">Select Marital Status</option>
                    <option value="Single" <?php echo (isset($_POST['marital_status']) && $_POST['marital_status'] == 'Single') ? 'selected' : ''; ?>>Single</option>
                    <option value="Married" <?php echo (isset($_POST['marital_status']) && $_POST['marital_status'] == 'Married') ? 'selected' : ''; ?>>Married</option>
                    <option value="Divorced" <?php echo (isset($_POST['marital_status']) && $_POST['marital_status'] == 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
                </select>

                <!-- Secondary Education -->
                <label for="secondary_education">Secondary Education:</label>
                <input type="text" name="secondary_education" placeholder="Enter your secondary education" value="<?php echo isset($_POST['secondary_education']) ? htmlspecialchars($_POST['secondary_education']) : ''; ?>">

                <!-- Higher Secondary -->
                <label for="higher_secondary">Higher Secondary:</label>
                <input type="text" name="higher_secondary" placeholder="Enter your higher secondary education" value="<?php echo isset($_POST['higher_secondary']) ? htmlspecialchars($_POST['higher_secondary']) : ''; ?>">

                <!-- Undergraduate -->
                <label for="undergrade">Undergraduate:</label>
                <input type="text" name="undergrade" placeholder="Enter your undergraduate degree" value="<?php echo isset($_POST['undergrade']) ? htmlspecialchars($_POST['undergrade']) : ''; ?>">

                <!-- Postgraduate -->
                <label for="post_grade">Postgraduate:</label>
                <input type="text" name="post_grade" placeholder="Enter your postgraduate degree" value="<?php echo isset($_POST['post_grade']) ? htmlspecialchars($_POST['post_grade']) : ''; ?>">

                <!-- Complexion -->
                <label for="complexion">Complexion:</label>
                <select name="complexion">
                    <option value="">Select Complexion</option>
                    <option value="Fair" <?php echo (isset($_POST['complexion']) && $_POST['complexion'] == 'Fair') ? 'selected' : ''; ?>>Fair</option>
                    <option value="Medium" <?php echo (isset($_POST['complexion']) && $_POST['complexion'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                    <option value="Olive" <?php echo (isset($_POST['complexion']) && $_POST['complexion'] == 'Olive') ? 'selected' : ''; ?>>Olive</option>
                    <option value="Tan" <?php echo (isset($_POST['complexion']) && $_POST['complexion'] == 'Tan') ? 'selected' : ''; ?>>Tan</option>
                    <option value="Dark" <?php echo (isset($_POST['complexion']) && $_POST['complexion'] == 'Dark') ? 'selected' : ''; ?>>Dark</option>
                </select>

                <!-- Height -->
                <label for="height">Height (in meters):</label>
                <input type="number" name="height" step="0.01" placeholder="Enter your height" value="<?php echo isset($_POST['height']) ? htmlspecialchars($_POST['height']) : ''; ?>">

                <!-- Submit Button -->
                <button type="submit">Filter</button>
            </form>
        </div>

        <!-- Main content area -->
        <div class="main-content">
            <h2>Your Best Matches</h2>
            <div class="profile-container" id="profile-container">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="profile reveal">
                            <img src="default-profile.png" alt="Profile Image"> <!-- Placeholder image -->
                            <div class="profile-info">
                                <h3><?= htmlspecialchars($row['First_Name'] . ' ' . $row['Last_Name']) ?></h3>
                                <p><strong>Age:</strong> <?= date_diff(date_create($row['DOB']), date_create('today'))->y ?></p>
                                <p><strong>Profession:</strong> <?= htmlspecialchars($row['Profession']) ?></p>
                                <p><strong>Religion:</strong> <?= htmlspecialchars($row['Religion']) ?></p>
                                <p><strong>Ethnicity:</strong> <?= htmlspecialchars($row['Ethnicity']) ?></p>
                                <p class="match-percentage">Match Strength: <?= rand(70, 100) ?>%</p> <!-- Example match percentage -->
                            </div>
                            <div class="profile-actions">
                                <a href="chatapp.php?user_id=<?= htmlspecialchars($row['user_id']) ?>">
                                    <button>Send Message Request</button>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No matches found.</p>
                <?php endif; ?>
                <?php $conn->close(); ?>
            </div>
        </div>
    </div>

    <script>
        function revealOnScroll() {
            const reveals = document.querySelectorAll('.reveal');
            reveals.forEach(function (reveal) {
                const windowHeight = window.innerHeight;
                const revealTop = reveal.getBoundingClientRect().top;
                const revealPoint = 150;

                if (revealTop < windowHeight - revealPoint) {
                    reveal.style.opacity = '1';
                    reveal.style.transform = 'translateY(0)';
                }
            });
        }

        window.addEventListener('scroll', revealOnScroll);
    </script>

</body>

</html>
