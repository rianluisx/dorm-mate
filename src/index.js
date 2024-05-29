document.addEventListener('DOMContentLoaded', function () {
    var permitCards = document.querySelectorAll('.permit-card');
    permitCards.forEach(function (card) {
        card.addEventListener('click', function () {
            var permit = JSON.parse(this.getAttribute('data-permit'));
            document.getElementById('modal-permit-type').textContent = permit.permit_type;
            document.getElementById('modal-permit-status').textContent = permit.permit_status;
            document.getElementById('modal-permit-status').className = 'badge bg-' + (permit.permit_status == 'pending' ? 'warning' : (permit.permit_status == 'approved' ? 'success' : 'danger'));
            document.getElementById('modal-date-filed').textContent = permit.date_filed;
            document.getElementById('modal-room-number').textContent = permit.room_number;
            document.getElementById('modal-time-out').textContent = permit.time_out;
            document.getElementById('modal-expected-date').textContent = permit.expected_date;
            document.getElementById('modal-destination').textContent = permit.destination;
            document.getElementById('modal-purpose').textContent = permit.purpose;
            document.getElementById('modal-in-care-of').textContent = permit.in_care_of;
            document.getElementById('modal-emergency-contact').textContent = permit.emergency_contact;
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const permitTypeSelect = document.getElementById('permitType');
    const expectedDateInput = document.getElementById('expected-date');

    permitTypeSelect.addEventListener('change', function () {
        const selectedPermitType = permitTypeSelect.value;
        if (selectedPermitType === 'overnight-permit') {
            setNextDayExpectedDate();
        } else if (selectedPermitType === 'late-night-permit') {
            setSameDayExpectedDate();
        } else {
            expectedDateInput.removeAttribute('min');
            expectedDateInput.removeAttribute('max');
            expectedDateInput.value = '';
        }
    });

    function setNextDayExpectedDate() {
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);
        const formattedDate = tomorrow.toISOString().substr(0, 10);
        expectedDateInput.setAttribute('min', formattedDate);
        expectedDateInput.setAttribute('max', formattedDate);
        expectedDateInput.value = formattedDate;
    }

    function setSameDayExpectedDate() {
        const today = new Date();
        const formattedDate = today.toISOString().substr(0, 10);
        expectedDateInput.setAttribute('min', formattedDate);
        expectedDateInput.setAttribute('max', formattedDate);
        expectedDateInput.value = formattedDate;
    }

    if (permitTypeSelect.value === 'late-night-permit') {
        setSameDayExpectedDate();
    } 
});


function checkPermitFilingTime() {
    const permitButton = document.getElementById('file-permit-button');
    const timerDisplay = document.getElementById('permit-timer');
    const currentTime = new Date();
    const currentHour = currentTime.getHours();

    const startHour = 6;  
    const endHour = 18;   

    if (currentHour >= startHour && currentHour < endHour) {
        permitButton.classList.remove('disabled');
        permitButton.disabled = false;
        timerDisplay.textContent = '';  
    } else {
        permitButton.classList.add('disabled');
        permitButton.disabled = true;
        
        let nextFilingTime;
        if (currentHour >= endHour) {
            
            nextFilingTime = new Date(currentTime.getFullYear(), currentTime.getMonth(), currentTime.getDate() + 1, 6, 0, 0);
        } else {
            
            nextFilingTime = new Date(currentTime.getFullYear(), currentTime.getMonth(), currentTime.getDate(), 6, 0, 0);
        }


        const timeDifference = nextFilingTime - currentTime;
        

        const hours = Math.floor(timeDifference / (1000 * 60 * 60));
        const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);


        timerDisplay.textContent = `You can file a permit in the next ${hours}h ${minutes}m ${seconds}s`;
    }
}


window.onload = () => {
    checkPermitFilingTime();
    setInterval(checkPermitFilingTime, 1000);
};