const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
    e.preventDefault(); // Prevent form from submitting traditionally
}

inputField.focus();
inputField.onkeyup = () => {
    if (inputField.value.trim() != "") { // Ensure it's not just empty spaces
        sendBtn.classList.add("active");
    } else {
        sendBtn.classList.remove("active");
    }
}

sendBtn.onclick = () => {
    // Create XMLHttpRequest to send message
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log("Message sent successfully:", xhr.responseText); // Debugging the response
                inputField.value = ""; // Clear the input field after sending
                scrollToBottom(); // Scroll to bottom to show the latest message
            } else {
                console.error("Error while sending message:", xhr.statusText); // Handle errors
            }
        }
    }

    // Collect form data and send it
    let formData = new FormData(form);
    console.log("Sending form data with incoming_id: " + incoming_id); // Debugging form data
    xhr.send(formData); // Send the form data (including incoming_id and message)
}

chatBox.onmouseenter = () => {
    chatBox.classList.add("active");
}

chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
}

// Fetch messages every 500ms
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.responseText;
                chatBox.innerHTML = data;
                if (!chatBox.classList.contains("active")) {
                    scrollToBottom(); // Scroll to bottom when new messages are loaded
                }
            } else {
                console.error("Error while fetching messages:", xhr.statusText); // Handle fetch errors
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id=" + encodeURIComponent(incoming_id)); // Send the incoming_id to get messages
}, 500);

// Function to automatically scroll chat to the bottom
function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight; // Automatically scroll to the bottom
}
