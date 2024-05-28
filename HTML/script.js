document.addEventListener('DOMContentLoaded', () => {
    fetch('fetch_user_data.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('firstName').value = data.first_name;
            document.getElementById('lastName').value = data.last_name;
            document.getElementById('phone').value = data.phone;
            document.getElementById('email').value = data.email;
            document.getElementById('birthDate').value = data.birth_date;
        })
        .catch(error => console.error('Error fetching user data:', error));
});

function cancelChanges() {
    window.location.href = 'profile.html'; // redirect to the profile page or home page
}
