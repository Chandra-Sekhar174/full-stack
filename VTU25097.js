// VTU25097.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('Vehicle Service App Initialized');
    
    // === CUSTOMER REGISTRATION SECTION ===
    const registerBtn = document.querySelector('button[type="submit"]:not(#bookingForm button)');
    const customerFormData = {};
    
    // Auto-format contact number
    document.getElementById('contact').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 10) {
            value = value.slice(0, 10);
        }
        e.target.value = value;
    });
    
    // Customer registration handler
    if (registerBtn) {
        registerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Collect form data
            const formData = {
                name: document.getElementById('cus_name').value,
                regId: document.getElementById('reg_id').value,
                contact: document.getElementById('contact').value,
                location: document.getElementById('location').value,
                dod: document.getElementById('dod').value
            };
            
            // Validation
            if (!validateCustomerForm(formData)) {
                showNotification('Please fill all required fields correctly!', 'error');
                return;
            }
            
            // Simulate API call
            registerBtn.textContent = 'Registering...';
            registerBtn.disabled = true;
            
            setTimeout(() => {
                customerFormData.regId = formData.regId;
                document.getElementById('cus_reg_id').value = formData.regId;
                
                // DOM Manipulation - Success feedback
                showNotification(`Customer ${formData.name} registered successfully! Reg ID: ${formData.regId}`, 'success');
                animateSuccess(registerBtn);
                
                registerBtn.textContent = 'Customer Registered ✓';
                registerBtn.style.background = 'linear-gradient(135deg, #10b981, #34d399)';
            }, 1500);
        });
    }
    
    // === VEHICLE SERVICE BOOKING SECTION ===
    const bookingForm = document.getElementById('bookingForm');
    const serviceTypeSelect = document.getElementById('service_type');
    const vehicleTypeSelect = document.getElementById('vehicle_type');
    const amountInput = document.getElementById('amount');
    
    // Dynamic pricing based on service type
    serviceTypeSelect.addEventListener('change', function() {
        const servicePrice = {
            'Cleaning': 500,
            'Repair': 1200,
            'Full Service': 2500,
            'Oil Change': 800,
            'Brake Check': 600
        };
        
        const price = servicePrice[this.value] || 0;
        amountInput.value = price;
        animateField(amountInput);
    });
    
    // Vehicle number validation and formatting
    document.getElementById('vehicle_no').addEventListener('input', function(e) {
        let value = e.target.value.toUpperCase();
        value = value.replace(/[^A-Z0-9-]/g, '');
        e.target.value = value;
    });
    
    // Booking form submission
    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = collectBookingFormData();
        
        if (!validateBookingForm(formData)) {
            return;
        }
        
        // Submit animation
        const submitBtn = bookingForm.querySelector('button[type="submit"]');
        submitBtn.textContent = 'Booking...';
        submitBtn.disabled = true;
        
        setTimeout(() => {
            // Success response
            showBookingConfirmation(formData);
            resetBookingForm();
            submitBtn.textContent = 'Booked Successfully ✓';
            submitBtn.style.background = 'linear-gradient(135deg, #10b981, #34d399)';
        }, 2000);
    });
    
    // === NAVBAR INTERACTIONS ===
    const navItems = document.querySelectorAll('.navbar h5');
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            highlightNavItem(this);
            showSection(this.textContent.toLowerCase());
        });
    });
    
    // === DYNAMIC DATE SETTING ===
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('service_date').min = today;
    document.getElementById('service_date').value = today;
    
    // === HELPER FUNCTIONS ===
    function validateCustomerForm(data) {
        if (!data.name || data.name.length < 2) return false;
        if (!data.regId || data.regId.toString().length !== 3) return false;
        if (!/^[987][0-9]{9}$/.test(data.contact)) return false;
        if (!data.location || data.location.length < 10) return false;
        return true;
    }
    
    function validateBookingForm(data) {
        if (data.cusRegId !== customerFormData.regId) {
            showNotification('Please register customer first or use correct Reg ID!', 'error');
            return false;
        }
        if (!data.vehicleNo || data.vehicleNo.length < 8) return false;
        if (!data.serviceType) return false;
        return true;
    }
    
    function collectBookingFormData() {
        return {
            cusRegId: document.getElementById('cus_reg_id').value,
            vehicleNo: document.getElementById('vehicle_no').value,
            vehicleType: document.getElementById('vehicle_type').value,
            serviceType: document.getElementById('service_type').value,
            serviceDate: document.getElementById('service_date').value,
            amount: document.getElementById('amount').value,
            remarks: document.getElementById('remarks').value
        };
    }
    
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.style.cssText = `
            position: fixed; top: 100px; right: 20px; z-index: 1000;
            padding: 15px 20px; border-radius: 8px; color: white;
            font-weight: 600; max-width: 350px; transform: translateX(400px);
            transition: transform 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        `;
        
        const colors = {
            success: '#10b981',
            error: '#ef4444',
            info: '#3b82f6'
        };
        notification.style.background = colors[type];
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }
    
    function animateSuccess(element) {
        element.style.transform = 'scale(1.05)';
        setTimeout(() => element.style.transform = 'scale(1)', 200);
    }
    
    function animateField(element) {
        element.style.borderColor = '#10b981';
        element.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.1)';
        setTimeout(() => {
            element.style.borderColor = '#4b5563';
            element.style.boxShadow = 'none';
        }, 1000);
    }
    
    function showBookingConfirmation(data) {
        const modal = document.createElement('div');
        modal.className = 'confirmation-modal';
        modal.innerHTML = `
            <div style="
                position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.8); z-index: 2000; display: flex;
                justify-content: center; align-items: center;
            ">
                <div style="
                    background: white; padding: 40px; border-radius: 15px;
                    max-width: 500px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.3);
                ">
                    <div style="font-size: 60px; color: #10b981; margin-bottom: 20px;">✓</div>
                    <h2>Booking Confirmed!</h2>
                    <p><strong>Vehicle:</strong> ${data.vehicleNo}</p>
                    <p><strong>Service:</strong> ${data.serviceType}</p>
                    <p><strong>Date:</strong> ${new Date(data.serviceDate).toLocaleDateString()}</p>
                    <p><strong>Amount:</strong> ₹${data.amount}</p>
                    <button onclick="this.parentElement.parentElement.remove()" style="
                        background: linear-gradient(135deg, #3b82f6, #60a5fa);
                        color: white; border: none; padding: 12px 30px;
                        border-radius: 25px; font-size: 16px; cursor: pointer; margin-top: 20px;
                    ">Close</button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }
    
    function highlightNavItem(activeItem) {
        navItems.forEach(item => {
            item.style.color = '#262052';
            item.style.textShadow = 'none';
        });
        activeItem.style.color = '#1e40af';
        activeItem.style.textShadow = '0 0 10px rgba(30, 64, 175, 0.5)';
    }
    
    function showSection(sectionName) {
        // Add smooth scroll to relevant section
        const sections = {
            'home': document.querySelector('.adds'),
            'service': document.querySelectorAll('.service')[0],
            'billing': document.querySelectorAll('.service')[1]
        };
        
        const targetSection = sections[sectionName] || document.querySelector('.service');
        targetSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    function resetBookingForm() {
        bookingForm.reset();
        document.getElementById('service_date').value = new Date().toISOString().split('T')[0];
        bookingForm.querySelector('button[type="submit"]').textContent = 'Book Service';
        bookingForm.querySelector('button[type="submit"]').disabled = false;
        bookingForm.querySelector('button[type="submit"]').style.background = '';
    }
    
    // Add CSS for notifications
    const style = document.createElement('style');
    style.textContent = `
        .notification { animation: slideIn 0.3s ease-out; }
        @keyframes slideIn { from { transform: translateX(400px); } to { transform: translateX(0); } }
    `;
    document.head.appendChild(style);
});
