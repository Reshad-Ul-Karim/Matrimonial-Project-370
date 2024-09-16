<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Include database connection file
include('DBconnect.php');

$matches = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form input
    $profession = htmlspecialchars($_POST['profession']);
    $gender = htmlspecialchars($_POST['gender']);
    $religion = htmlspecialchars($_POST['religion']);
    $ethnicity = htmlspecialchars($_POST['ethnicity']);
    $marital_status = htmlspecialchars($_POST['marital_status']);
    $secondary_education = htmlspecialchars($_POST['secondary_education']);
    $higher_secondary = htmlspecialchars($_POST['higher_secondary']);
    $undergrade = htmlspecialchars($_POST['undergrade']);
    $post_grade = htmlspecialchars($_POST['post_grade']);
    $complexion = htmlspecialchars($_POST['complexion']);
    $user_height = htmlspecialchars($_POST['height']); // User's height in meters
    $min_age = htmlspecialchars($_POST['min_age']); // Preferred minimum age
    $max_age = htmlspecialchars($_POST['max_age']); // Preferred maximum age

    // Redirect to the results page with query parameters
    header("Location: search_result.php?$query");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search For Matches</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Product+Sans&display=swap');
        body {
            margin: 0;
            font-family: 'Product Sans', Arial, sans-serif;
            background: linear-gradient(135deg, #ff6f61, #ffe5b4);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .profile-container {
            background-color: #ffffff;
            padding: 20px;
            width: 600px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin: 40px 0;
        }
        input[type="text"], input[type="date"], input[type="number"], select, textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input:focus, select:focus, textarea:focus { border-color: #ff6f61; outline: none; }
        .submit-btn { margin:2px; width: 100%; padding: 10px; background-color: #ff6f61; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease; }
        .submit-btn:hover { background-color: #ff4f41; }
        h2 { text-align: center; color: #ff6f61; margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        textarea { resize: vertical; }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Search For Matches</h2>
    <form method="POST" action="">
        <!-- Profession -->
        <label for="profession">Profession:</label>
        <select name="profession" required>
            <optgroup label="Technology and IT">
                <option value="software-engineer">Software Engineer</option>
                <option value="data-scientist">Data Scientist</option>
                <option value="it-support-specialist">IT Support Specialist</option>
                <option value="web-developer">Web Developer</option>
                <option value="cybersecurity-analyst">Cybersecurity Analyst</option>
                <option value="cloud-engineer">Cloud Engineer</option>
                <option value="network-administrator">Network Administrator</option>
                <option value="mobile-app-developer">Mobile App Developer</option>
                <option value="ux-ui-designer">UX/UI Designer</option>
                <option value="blockchain-developer">Blockchain Developer</option>
                <option value="ai-engineer">Artificial Intelligence Engineer</option>
                <option value="game-developer">Game Developer</option>
            </optgroup>
            
            <optgroup label="Healthcare and Medicine">
                <option value="doctor">Doctor/Physician</option>
                <option value="nurse">Nurse</option>
                <option value="dentist">Dentist</option>
                <option value="pharmacist">Pharmacist</option>
                <option value="physical-therapist">Physical Therapist</option>
                <option value="psychologist">Psychologist</option>
                <option value="medical-research-scientist">Medical Research Scientist</option>
                <option value="occupational-therapist">Occupational Therapist</option>
                <option value="radiologist">Radiologist</option>
                <option value="paramedic">Paramedic</option>
                <option value="optometrist">Optometrist</option>
                <option value="veterinarian">Veterinarian</option>
            </optgroup>
            
            <optgroup label="Engineering and Architecture">
                <option value="civil-engineer">Civil Engineer</option>
                <option value="mechanical-engineer">Mechanical Engineer</option>
                <option value="electrical-engineer">Electrical Engineer</option>
                <option value="chemical-engineer">Chemical Engineer</option>
                <option value="aerospace-engineer">Aerospace Engineer</option>
                <option value="environmental-engineer">Environmental Engineer</option>
                <option value="biomedical-engineer">Biomedical Engineer</option>
                <option value="industrial-engineer">Industrial Engineer</option>
                <option value="architect">Architect</option>
                <option value="urban-planner">Urban Planner</option>
                <option value="structural-engineer">Structural Engineer</option>
            </optgroup>
            
            <optgroup label="Business and Finance">
                <option value="accountant">Accountant</option>
                <option value="financial-analyst">Financial Analyst</option>
                <option value="investment-banker">Investment Banker</option>
                <option value="hr-manager">Human Resources Manager</option>
                <option value="marketing-manager">Marketing Manager</option>
                <option value="sales-manager">Sales Manager</option>
                <option value="business-consultant">Business Consultant</option>
                <option value="project-manager">Project Manager</option>
                <option value="entrepreneur">Entrepreneur</option>
                <option value="economist">Economist</option>
                <option value="real-estate-agent">Real Estate Agent</option>
                <option value="operations-manager">Operations Manager</option>
            </optgroup>
            
            <optgroup label="Creative Arts and Design">
                <option value="graphic-designer">Graphic Designer</option>
                <option value="interior-designer">Interior Designer</option>
                <option value="fashion-designer">Fashion Designer</option>
                <option value="photographer">Photographer</option>
                <option value="animator">Animator</option>
                <option value="art-director">Art Director</option>
                <option value="copywriter">Copywriter</option>
                <option value="music-producer">Music Producer</option>
                <option value="video-editor">Video Editor</option>
                <option value="game-designer">Game Designer</option>
                <option value="illustrator">Illustrator</option>
            </optgroup>
            
            <optgroup label="Education and Training">
                <option value="teacher">Teacher</option>
                <option value="university-professor">University Professor</option>
                <option value="school-counselor">School Counselor</option>
                <option value="corporate-trainer">Corporate Trainer</option>
                <option value="educational-consultant">Educational Consultant</option>
                <option value="librarian">Librarian</option>
                <option value="curriculum-developer">Curriculum Developer</option>
                <option value="special-education-teacher">Special Education Teacher</option>
                <option value="researcher">Researcher</option>
            </optgroup>
            
            <optgroup label="Law and Public Services">
                <option value="lawyer">Lawyer</option>
                <option value="paralegal">Paralegal</option>
                <option value="judge">Judge</option>
                <option value="police-officer">Police Officer</option>
                <option value="firefighter">Firefighter</option>
                <option value="social-worker">Social Worker</option>
                <option value="politician">Politician</option>
                <option value="diplomat">Diplomat</option>
                <option value="public-relations-specialist">Public Relations Specialist</option>
                <option value="probation-officer">Probation Officer</option>
            </optgroup>
            
            <optgroup label="Science and Research">
                <option value="biologist">Biologist</option>
                <option value="chemist">Chemist</option>
                <option value="physicist">Physicist</option>
                <option value="environmental-scientist">Environmental Scientist</option>
                <option value="geologist">Geologist</option>
                <option value="astronomer">Astronomer</option>
                <option value="forensic-scientist">Forensic Scientist</option>
                <option value="marine-biologist">Marine Biologist</option>
                <option value="meteorologist">Meteorologist</option>
                <option value="geneticist">Geneticist</option>
            </optgroup>
            
            <optgroup label="Media and Communication">
                <option value="journalist">Journalist</option>
                <option value="news-anchor">News Anchor</option>
                <option value="public-relations-specialist">Public Relations Specialist</option>
                <option value="content-writer">Content Writer</option>
                <option value="editor">Editor</option>
                <option value="blogger">Blogger</option>
                <option value="radio-host">Radio Host</option>
                <option value="film-director">Film Director</option>
                <option value="social-media-manager">Social Media Manager</option>
                <option value="podcast-producer">Podcast Producer</option>
            </optgroup>
            
            <optgroup label="Trades and Skilled Labor">
                <option value="electrician">Electrician</option>
                <option value="plumber">Plumber</option>
                <option value="carpenter">Carpenter</option>
                <option value="mechanic">Mechanic</option>
                <option value="welder">Welder</option>
                <option value="hvac-technician">HVAC Technician</option>
                <option value="truck-driver">Truck Driver</option>
                <option value="construction-worker">Construction Worker</option>
                <option value="landscaper">Landscaper</option>
                <option value="painter">Painter</option>
            </optgroup>
            
            <optgroup label="Hospitality and Tourism">
                <option value="hotel-manager">Hotel Manager</option>
                <option value="travel-agent">Travel Agent</option>
                <option value="chef">Chef</option>
                <option value="event-planner">Event Planner</option>
                <option value="flight-attendant">Flight Attendant</option>
                <option value="tour-guide">Tour Guide</option>
                <option value="restaurant-manager">Restaurant Manager</option>
                <option value="cruise-director">Cruise Director</option>
            </optgroup>
            
            <optgroup label="Sports and Fitness">
                <option value="professional-athlete">Professional Athlete</option>
                <option value="fitness-trainer">Fitness Trainer</option>
                <option value="sports-coach">Sports Coach</option>
                <option value="sports-analyst">Sports Analyst</option>
                <option value="physical-education-teacher">Physical Education Teacher</option>
                <option value="sports-psychologist">Sports Psychologist</option>
                <option value="sports-manager">Sports Manager</option>
            </optgroup>
            
            <optgroup label="Environment and Sustainability">
                <option value="environmental-consultant">Environmental Consultant</option>
                <option value="conservation-scientist">Conservation Scientist</option>
                <option value="ecologist">Ecologist</option>
                <option value="agricultural-scientist">Agricultural Scientist</option>
                <option value="renewable-energy-specialist">Renewable Energy Specialist</option>
                <option value="sustainability-coordinator">Sustainability Coordinator</option>
                <option value="wildlife-biologist">Wildlife Biologist</option>
            </optgroup>
            
            <optgroup label="Freelance and Remote Work">
                <option value="virtual-assistant">Virtual Assistant</option>
                <option value="freelance-writer">Freelance Writer</option>
                <option value="freelance-graphic-designer">Freelance Graphic Designer</option>
                <option value="online-tutor">Online Tutor</option>
                <option value="digital-marketing-consultant">Digital Marketing Consultant</option>
                <option value="e-commerce-specialist">E-commerce Specialist</option>
                <option value="freelance-software-developer">Freelance Software Developer</option>
            </optgroup>
        </select>


        <!-- Gender -->
        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <!-- Religion -->
        <label for="religion">Religion:</label>
        <select name="religion" required>
            <option value="Muslim">Muslim</option>
            <option value="Hindu">Hindu</option>
            <option value="Christian">Christian</option>
            <option value="Buddhist">Buddhist</option>
            <!-- Add more religion options here -->
        </select>

        <!-- Ethnicity -->
        <label for="ethnicity">Ethnicity:</label>
        <select name="ethnicity" required>
            <option value="Caucasian">Caucasian</option>
            <option value="African">African</option>
            <option value="Asian">Asian</option>
            <option value="Hispanic">Hispanic</option>
            <option value="Other">Other</option>
        </select>

        <!-- Marital Status -->
        <label for="marital_status">Marital Status:</label>
        <select name="marital_status" required>
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Divorced">Divorced</option>
        </select>

        <!-- Secondary Education -->
        <label for="secondary_education">Secondary Education:</label>
        <input type="text" name="secondary_education" placeholder="Enter your secondary education">

        <!-- Higher Secondary -->
        <label for="higher_secondary">Higher Secondary:</label>
        <input type="text" name="higher_secondary" placeholder="Enter your higher secondary education">

        <!-- Undergraduate -->
        <label for="undergrade">Undergraduate:</label>
        <input type="text" name="undergrade" placeholder="Enter your undergraduate degree">

        <!-- Postgraduate -->
        <label for="post_grade">Postgraduate:</label>
        <input type="text" name="post_grade" placeholder="Enter your postgraduate degree">

        <!-- Complexion -->
        <label for="complexion">Complexion:</label>
        <select name="complexion" required>
            <option value="Fair">Fair</option>
            <option value="Medium">Medium</option>
            <option value="Olive">Olive</option>
            <option value="Tan">Tan</option>
            <option value="Dark">Dark</option>
        </select>
        <!-- Height (m) -->
        <label for="height">Height (meters):</label>
        <input type="number" name="height" step="0.01" placeholder="Enter height in meters" required>

        <!-- Age Range -->
        <label for="min_age">Minimum Age:</label>
        <input type="number" name="min_age" min="18" placeholder="Min age" required>

        <label for="max_age">Maximum Age:</label>
        <input type="number" name="max_age" max="100" placeholder="Max age" required>
        <!-- Submit Button -->
        <button type="submit" class="submit-btn">search for result</button>
    </form>
    <button type="submit" class="submit-btn" onclick="window.location.href='index.php';">Back to dashboard</button>
</div>

</body>
</html>