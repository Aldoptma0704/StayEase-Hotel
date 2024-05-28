function searchRooms() {
    const checkIn = document.getElementById('check-in').value;
    const checkOut = document.getElementById('check-out').value;
    const rooms = document.getElementById('rooms').value;
  
    const roomElements = document.querySelectorAll('.room-info');
    roomElements.forEach(room => {
      const roomCount = room.getAttribute('data-rooms');
  
      if (parseInt(rooms) == parseInt(roomCount)) {
        room.style.display = 'flex'; // Display matching rooms
      } else {
        room.style.display = 'none'; // Hide non-matching rooms
      }
    });
  }
  