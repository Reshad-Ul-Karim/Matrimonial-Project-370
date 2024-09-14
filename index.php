<?php
ob_start(); // Turn on output buffering
session_start(); // Start the session

require_once("DBconnect.php");

// Check if the user is already logged in, redirect to home.php if true
if (isset($_SESSION['user_id'])) {
  header('Location: dashboard.php');
  exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (!empty($email) && !empty($password)) {
      $sql = "SELECT user_id, Password FROM User WHERE Email = '$email'";
      $result = mysqli_query($conn, $sql);
      if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          if (password_verify($password, $row['Password'])) {
              $_SESSION['user_id'] = $row['user_id'];
              $_SESSION['email'] = $email;
              header("Location: dashboard.php");
              exit;
          } else {
              $error = 'Invalid password!';
          }
      } else {
          $error = 'No user found with that email address!';
      }
  } else {
      $error = 'Please fill in both email and password!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Matrimonial Hub</title>
    <style>
        /* cyrillic */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 100;
        src: local('Product Sans Thin Italic'), local('ProductSans-ThinItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxifypQkot1TnFhsFMOfGShVEu_vWEpkr1ap.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 100;
        src: local('Product Sans Thin Italic'), local('ProductSans-ThinItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxifypQkot1TnFhsFMOfGShVEu_vWE1kr1ap.woff2) format('woff2');
        unicode-range: U+0370-03FF;
        }
        /* latin-ext */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 100;
        src: local('Product Sans Thin Italic'), local('ProductSans-ThinItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxifypQkot1TnFhsFMOfGShVEu_vWEBkr1ap.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 100;
        src: local('Product Sans Thin Italic'), local('ProductSans-ThinItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxifypQkot1TnFhsFMOfGShVEu_vWE5krw.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* cyrillic */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 300;
        src: local('Product Sans Light Italic'), local('ProductSans-LightItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu8nSllHimuQpw.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 300;
        src: local('Product Sans Light Italic'), local('ProductSans-LightItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu8nSllAimuQpw.woff2) format('woff2');
        unicode-range: U+0370-03FF;
        }
        /* latin-ext */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 300;
        src: local('Product Sans Light Italic'), local('ProductSans-LightItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu8nSllNimuQpw.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 300;
        src: local('Product Sans Light Italic'), local('ProductSans-LightItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu8nSllDims.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* cyrillic */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 400;
        src: local('Product Sans Italic'), local('ProductSans-Italic'), url(https://fonts.gstatic.com/s/productsans/v9/pxidypQkot1TnFhsFMOfGShVEueIaEx8qw.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 400;
        src: local('Product Sans Italic'), local('ProductSans-Italic'), url(https://fonts.gstatic.com/s/productsans/v9/pxidypQkot1TnFhsFMOfGShVEuePaEx8qw.woff2) format('woff2');
        unicode-range: U+0370-03FF;
        }
        /* latin-ext */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 400;
        src: local('Product Sans Italic'), local('ProductSans-Italic'), url(https://fonts.gstatic.com/s/productsans/v9/pxidypQkot1TnFhsFMOfGShVEueCaEx8qw.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 400;
        src: local('Product Sans Italic'), local('ProductSans-Italic'), url(https://fonts.gstatic.com/s/productsans/v9/pxidypQkot1TnFhsFMOfGShVEueMaEw.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* cyrillic */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 500;
        src: local('Product Sans Medium Italic'), local('ProductSans-MediumItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu9_S1lHimuQpw.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 500;
        src: local('Product Sans Medium Italic'), local('ProductSans-MediumItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu9_S1lAimuQpw.woff2) format('woff2');
        unicode-range: U+0370-03FF;
        }
        /* latin-ext */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 500;
        src: local('Product Sans Medium Italic'), local('ProductSans-MediumItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu9_S1lNimuQpw.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 500;
        src: local('Product Sans Medium Italic'), local('ProductSans-MediumItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu9_S1lDims.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* cyrillic */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 700;
        src: local('Product Sans Bold Italic'), local('ProductSans-BoldItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu83TVlHimuQpw.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 700;
        src: local('Product Sans Bold Italic'), local('ProductSans-BoldItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu83TVlAimuQpw.woff2) format('woff2');
        unicode-range: U+0370-03FF;
        }
        /* latin-ext */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 700;
        src: local('Product Sans Bold Italic'), local('ProductSans-BoldItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu83TVlNimuQpw.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 700;
        src: local('Product Sans Bold Italic'), local('ProductSans-BoldItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu83TVlDims.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* cyrillic */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 900;
        src: local('Product Sans Black Italic'), local('ProductSans-BlackItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu8PT1lHimuQpw.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 900;
        src: local('Product Sans Black Italic'), local('ProductSans-BlackItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu8PT1lAimuQpw.woff2) format('woff2');
        unicode-range: U+0370-03FF;
        }
        /* latin-ext */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 900;
        src: local('Product Sans Black Italic'), local('ProductSans-BlackItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu8PT1lNimuQpw.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
        font-family: 'Product Sans';
        font-style: italic;
        font-weight: 900;
        src: local('Product Sans Black Italic'), local('ProductSans-BlackItalic'), url(https://fonts.gstatic.com/s/productsans/v9/pxieypQkot1TnFhsFMOfGShVEu8PT1lDims.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* cyrillic */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 100;
        src: local('Product Sans Thin'), local('ProductSans-Thin'), url(https://fonts.gstatic.com/s/productsans/v9/pxidypQkot1TnFhsFMOfGShddOeIaEx8qw.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 100;
        src: local('Product Sans Thin'), local('ProductSans-Thin'), url(https://fonts.gstatic.com/s/productsans/v9/pxidypQkot1TnFhsFMOfGShddOePaEx8qw.woff2) format('woff2');
        unicode-range: U+0370-03FF;
        }
        /* latin-ext */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 100;
        src: local('Product Sans Thin'), local('ProductSans-Thin'), url(https://fonts.gstatic.com/s/productsans/v9/pxidypQkot1TnFhsFMOfGShddOeCaEx8qw.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 100;
        src: local('Product Sans Thin'), local('ProductSans-Thin'), url(https://fonts.gstatic.com/s/productsans/v9/pxidypQkot1TnFhsFMOfGShddOeMaEw.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* cyrillic */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 300;
        src: local('Product Sans Light'), local('ProductSans-Light'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShdvPWbS2lBkm8.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 300;
        src: local('Product Sans Light'), local('ProductSans-Light'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShdvPWbTGlBkm8.woff2) format('woff2');
        unicode-range: U+0370-03FF;
        }
        /* latin-ext */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 300;
        src: local('Product Sans Light'), local('ProductSans-Light'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShdvPWbQWlBkm8.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 300;
        src: local('Product Sans Light'), local('ProductSans-Light'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShdvPWbT2lB.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* cyrillic */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 400;
        src: local('Product Sans'), local('ProductSans-Regular'), url(https://fonts.gstatic.com/s/productsans/v9/pxiDypQkot1TnFhsFMOfGShVE9eOcEg.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 400;
        src: local('Product Sans'), local('ProductSans-Regular'), url(https://fonts.gstatic.com/s/productsans/v9/pxiDypQkot1TnFhsFMOfGShVFNeOcEg.woff2) format('woff2');
        unicode-range: U+0370-03FF;
        }
        /* latin-ext */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 400;
        src: local('Product Sans'), local('ProductSans-Regular'), url(https://fonts.gstatic.com/s/productsans/v9/pxiDypQkot1TnFhsFMOfGShVGdeOcEg.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 400;
        src: local('Product Sans'), local('ProductSans-Regular'), url(https://fonts.gstatic.com/s/productsans/v9/pxiDypQkot1TnFhsFMOfGShVF9eO.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* cyrillic */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 500;
        src: local('Product Sans Medium'), local('ProductSans-Medium'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShd5PSbS2lBkm8.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 500;
        src: local('Product Sans Medium'), local('ProductSans-Medium'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShd5PSbTGlBkm8.woff2) format('woff2');
        unicode-range: U+0370-03FF;
        }
        /* latin-ext */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 500;
        src: local('Product Sans Medium'), local('ProductSans-Medium'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShd5PSbQWlBkm8.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 500;
        src: local('Product Sans Medium'), local('ProductSans-Medium'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShd5PSbT2lB.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* cyrillic */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 700;
        src: local('Product Sans Bold'), local('ProductSans-Bold'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShdrPKbS2lBkm8.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 700;
        src: local('Product Sans Bold'), local('ProductSans-Bold'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShdrPKbTGlBkm8.woff2) format('woff2');
        unicode-range: U+0370-03FF;
        }
        /* latin-ext */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 700;
        src: local('Product Sans Bold'), local('ProductSans-Bold'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShdrPKbQWlBkm8.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 700;
        src: local('Product Sans Bold'), local('ProductSans-Bold'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShdrPKbT2lB.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* cyrillic */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 900;
        src: local('Product Sans Black'), local('ProductSans-Black'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShdlPCbS2lBkm8.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 900;
        src: local('Product Sans Black'), local('ProductSans-Black'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShdlPCbTGlBkm8.woff2) format('woff2');
        unicode-range: U+0370-03FF;
        }
        /* latin-ext */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 900;
        src: local('Product Sans Black'), local('ProductSans-Black'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShdlPCbQWlBkm8.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
        font-family: 'Product Sans';
        font-style: normal;
        font-weight: 900;
        src: local('Product Sans Black'), local('ProductSans-Black'), url(https://fonts.gstatic.com/s/productsans/v9/pxicypQkot1TnFhsFMOfGShdlPCbT2lB.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        
        body {
            font-family: 'Product Sans';
            /* background: linear-gradient(135deg, #B32800, #7F0000, #E9A200); */
            background-image: url('login.png');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            justify-content: center;
            display: flex;
            align-items: center;
        }
        .container {
            max-width: 500px;
            margin: 100px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        h2 {
            font-size: 24;
        }
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
            font-size: 18px;
        }
        input[type="email"], input[type="password"] {
            width: calc(100% - 20px);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
            font-size: 16px;

        }
        button[type="submit"] {
            background-color: #c2155b;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease
        }
        button[type="submit"]:hover {
            background-color: #ad1457;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body id = "product-sans">
    <div class="container">
        <h2>Login to Matrimonial Hub</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="index.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" class="btn">Login</button>
        </form>
        <?php if ($error): ?>
              <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>