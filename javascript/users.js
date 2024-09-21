const searchBar = document.querySelector(".search input"),
searchIcon = document.querySelector(".search button"),
usersList = document.querySelector(".users-list");

searchIcon.onclick = ()=>{
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if(searchBar.classList.contains("active")){
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
}

let typingTimer;
searchBar.onkeyup = ()=>{
  clearTimeout(typingTimer); // Prevent multiple search requests while typing
  let searchTerm = searchBar.value;
  typingTimer = setTimeout(() => {
    if (searchTerm != "") {
      searchBar.classList.add("active");
    } else {
      searchBar.classList.remove("active");
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/search.php", true);
    xhr.onload = ()=>{
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          usersList.innerHTML = data; // Populate the user list with search results
        }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
  }, 300); // Delay of 300ms for efficient search requests
}

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/users.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(!searchBar.classList.contains("active")){
            usersList.innerHTML = data; // Update the user list periodically
          }
        }
    }
  }
  xhr.send();
}, 1000); // Increased interval to 1 seconds for better efficiency
