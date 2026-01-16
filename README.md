## FINAL REPORT INFO 3305 - GROUP 2 SEC 5
## GROUP MEMBERS
- MUHAMMAD DARWISY NASRY BIN SYARDI 2318549
- NAZMI ZAHIN BIN MOHD FAUZI 2319489
- MUHAMMAD HAZIQ ZULHAZMI BIN HAIRUL NIZAM 2224537
- MUHAMMAD NAZRAN BIN LOKMAN 2314089
## PROJECT TITLE 
COURT BOOKING SYSTEM (IIUM CBS)
## INTRODUCTION
The Court Booking System is a web application built using the Laravel Model-View-Controller (MVC) framework that allows users to find and reserve sports courts quickly and reliably. Many campus sports centres and community halls still use manual or semi-manual booking processes which cause double bookings, confusion about availability and difficulty tracking past reservations. This system will provide a clear online interface for users to view courts, check available time slots and make reservations. It will also provide an admin dashboard where staff can add courts, manage availability and approve or reject bookings. By using Laravel’s routing, Blade templating, Models, Controllers, Views, Eloquent ORM, and built-in authentication, the project will be structured, maintainable and easier to develop.
## OBJECTIVES
- The first objective is to provide a simple online platform where users which are students and staff can view available courts and reserve time slots without needing to contact staff in person or via messaging apps.
- The second objective is to reduce booking conflicts by enforcing an automatic overlap check so that double bookings cannot happen.
- The third objective is to provide administrators with tools to manage courts and bookings efficiently, including the ability to add new courts, set availability rules and change booking statuses.
- The final objective is to keep a clear record of bookings so that both users and administrators can view booking history for auditing and planning.
## FEATURES AND FUNCTIONALITIES
- **User Authentication and Roles :**
Users can register and log in using the built-in Laravel authentication which is Laravel Jetstream. There will be two roles where normal users can book courts and admin can manage courts and bookings. Role-based middleware will protect admin pages.
- **Home Page and Court Listing :**
The home page will display swiper of the sport's image with a button to redirect(scroll down) to Select Sport section below. In Select Sport section, users can select their sports and it show the list of available courts for their preferred choice such as Badminton, Futsal, Tennis , Volleyball with the court names and price stated. Also, users also can see the previous customer reviews that display in cards and users can leave their message on Contact Us section.
- **Booking Page :**
When a user clicks Book Now button from the list of courts, the system will display the chosen court image and users can start booking by choose a date and pick a time slot. Then, system will calculate and display the total price need to pay. If user want to edit or change the time/ date of the booking they can click the edit button and it will redirect again to booking where choose date and time again.
- **Booking Flow :**
Users can choose a fixed time slot. The booking request will run an overlap check on the server. If no conflict is found, the booking will be saved with a status such as pending or approved. Users can view their bookings status from a personal dashboard after paying amount stated and upload the receipt on payment page for admin to review their booking.
- **Overlap Prevention :**
The system will check if another booking already exists for the same court and time slot. If a slot is already taken, the system will not allow the user to book it again. This prevents double booking.
- **Admin Page and Dashboard :**
Admins will have a dashboard showing total courts, pending bookings, total users, table list of bookings of made that can view the receipt to be review and sidebar to add courts/facility , manage bookings and view user list. The admin can add/edit/delete courts ,change opening hours on add facility page,  update booking status like approve, reject, pending on manage booking page and view list of users on user list page.
- **Booking History :**
Users can view all their past and upcoming bookings in their dashboard. After making a booking, the system will show a confirmation message on the screen where users can choose to navigate to user dashboard or go back to home page. For upcoming bookings, it will show in card where the details of the approved booking can be see and for booking history it will show in table of list of bookings that have been made by the user.
- **Simple Media & Design :**
The system will use court images, basic Bootstrap cards, forms, and tables to keep the design clean and easy to use. We avoid complex effects like animations or drag-and-drop so the development stays simple and manageable.
## ERD, SEQUENCE DIAGRAM, MOCKUP
https://docs.google.com/document/d/1RzVBM78eK_Ag9nEFiNBm-nMRCwChd7UZ64u27HG4e4Q/edit?tab=t.0#heading=h.tzmkcxnpdxfm
## REFERENCES
- Free Bootstrap Themes and Website Templates | BootstrapMade. (n.d.). Bootstrapmade.com. https://bootstrapmade.com/ 
- Blade Templates - Laravel 12.x - The PHP Framework For Web Artisans. (2025). Laravel.com. https://laravel.com/docs/12.x/blade 
- Controllers - Laravel 12.x - The PHP Framework For Web Artisans. (2025). Laravel.com. https://laravel.com/docs/12.x/controllers 
- LucidChart. (2024). What is an Entity Relationship Diagram (ERD)? Lucidchart. https://www.lucidchart.com/pages/er-diagrams 
- Lucidchart. (2019). UML Sequence Diagram Tutorial. Lucidchart. https://www.lucidchart.com/pages/uml-sequence-diagram 
- 10,000+ Free Website Templates & Themes to Customize | Figma. (2025). Figma.https://www.figma.com/community/website-templates?resource_type=mixed&editor_type=all&price=all&sort_by=all_time&creators=all 
## 1. Technical Implementation
### **How the System Works**
#### **The User Journey**
1.  **Authentication**: Users register and log in via Laravel Jetstream. The system assigns roles to distinguish between standard users and administrators.
2.  **Facility Discovery**: The Home Page features a sports gallery. Users can jump to the "Select Sport" section to filter courts by category (Badminton, Futsal, Tennis, or Volleyball).
3.  **Court Selection**: In the "Select Sport" area, available courts are displayed with their specific names and hourly rates. Users can also view feedback before deciding.
4.  **Booking & Pricing**: On the Booking Page, users select a date and a fixed time slot. The system automatically calculates and displays the total price. Users have the flexibility to edit their date/time selection before finalizing.
5.  **Validation (Overlap Prevention)**: Upon submission, the server executes a check to ensure the chosen court and time slot do not conflict with existing "Approved" or "Pending" bookings. If a conflict exists, the booking is blocked to prevent double-booking.
6.  **Payment & Submission**: Users must upload a digital payment receipt. Once uploaded, the booking is saved with a "Pending" status.
7.  **Status Tracking**: Users can manage their requests in a Dashboard. Upcoming bookings are displayed as cards for easy viewing, while past bookings are archived in a detailed history table.
#### **The Administrative Workflow**
1.  **Centralized Monitoring**: Admins access a dashboard displaying key metrics: total courts, pending bookings, and total registered users.
2.  **Booking Review**: Admins review payment receipts through a management table. They hold the authority to Approve, Reject, or keep a booking as Pending.
3.  **Facility Management**: Through the sidebar, admins can perform full CRUD (Create, Read, Update, Delete) operations on courts and adjust the facility.
4.  **User Oversight**: A dedicated user list page allows admins to monitor all registered accounts on the platform.
### **Technology Stack**
The application is built using a modern full-stack approach:
* **Backend Framework**: Laravel 12.x
* **Frontend Framework**: Bootstrap 5.3 & Tailwind CSS
* **Build Tool**: [Vite]
* **Interactive Libraries**: Swiper.js, SweetAlert2, and AJAX
* **Database**: MySQL 15.1 MariaDB 10.4.32
* **Development Environment**: XAMPP
### **Database Design**
Our database consists of 3 main tables designed to handle users, sports facilities, and reservation records:
**Core Tables:**
- **users** – User and admin accounts with role-based access.
- **courts** – Information about sports facilities, including court names, types, and hourly rates.
- **bookings** – Records of court reservations, including dates, time slots, group IDs, payment receipts, and status.
**Key Relationships:**
* **One-to-Many**: A User can have many Bookings.
* **One-to-Many**: A Category contains many Courts.
* **One-to-Many**: A Court can be associated with many Bookings.
 ## 2. Laravel Component Implementation
### **Routes (`routes/web.php`)**
The application uses **Laravel Jetstream** middleware to handle role-based access. A custom "Traffic Cop" logic redirects users to the appropriate interface upon login:
```php
// --- PUBLIC ROUTES ---
Route::get('/', [CourtController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::post('/contact-submit', [ContactController::class, 'sendEmail'])->name('contact.send');
// --- AUTHENTICATED ROUTES (Jetstream) ---
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Dashboard Redirection (Traffic Cop)
    Route::get('/dashboard', function () {
        return Auth::user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('home');
    })->name('dashboard');
    // User Booking Flow
    Route::get('/courts/{id}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::get('/bookings/check', [BookingController::class, 'checkAvailability'])->name('bookings.check'); // AJAX Overlap Check
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/confirmation/{group_id}', [BookingController::class, 'confirmation'])->name('bookings.confirmation');
     Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.dashboard');
    // Payment Process
    Route::get('/payment/{group_id}', [BookingController::class, 'payment'])->name('bookings.payment');
    Route::post('/payment/submit/{group_id}', [BookingController::class, 'submitPayment'])->name('bookings.submit_payment');
    Route::post('/bookings/cancel/{group_id}', [BookingController::class, 'cancel'])->name('bookings.cancel');
    // --- ADMIN BACKEND ---
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('courts', CourtController::class)->except(['index', 'show']);
        Route::get('/bookings', [BookingController::class, 'indexAdmin'])->name('bookings.index');
        Route::post('/bookings/approve/{group_id}', [BookingController::class, 'approve'])->name('bookings.approve');
        Route::post('/bookings/reject/{group_id}', [BookingController::class, 'reject'])->name('bookings.reject');
        Route::get('/users', [BookingController::class, 'userList'])->name('users.index');
    });
});
```
### **Main Controllers**
*Main Controllers Implemented are below:*
1. **CourtController**: Handles the public display of available sports facilities and administrative CRUD operations for courts.
2. **BookingController**: The central engine that manages real-time availability checks (AJAX), session-based booking, payment submissions, and reservation history.
3. **ContactController**: Processes inquiry messages submitted through the "Contact Us" section and handles email notifications.
- **Models and Relationships**
  
```php
// User Model
class User extends Authenticatable {
    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}
// Court Model  
class Court extends Model {
    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}
// Booking Model
class Booking extends Model {
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function court() {
        return $this->belongsTo(Court::class);
    }
}
```
- **Views and User Interface**
  *Blade Templates Structure:*
  - **master/layout.blade.php** - The primary master layout providing the Bootstrap 5 scaffold, fonts, and global navigation.
  - **courts/index.blade.php** - Homepage featuring the Swiper.js sport discovery gallery and available court listings.
  - **about.blade.php** - Information page regarding the IIUM Sports Centre's mission and facility standards.
  - **bookings/create.blade.php** - Interactive booking form for picking specific courts, dates, and hourly time-slots.
  - **bookings/confirmation.blade.php** - Summary page for reviewing session-based booking details before proceeding to payment.
  - **bookings/payment.blade.php** - Secure portal for scanning QR codes and uploading digital payment receipts.
  - **bookings/success.blade.php** - Confirmation page displaying the unique Booking Reference ID after a successful submission.
  - **admin/dashboard.blade.php** - Administrative control center featuring a fixed gradient sidebar and high-level system statistics.
   *Design Features:*
   - **Responsive Design**: Mobile-first approach built with **Bootstrap 5.3** to ensure compatibility across all screen sizes.
   - **Color Scheme**: Green and white theme professionalizing the campus sports experience.
   - **Navigation**: Intuitive role-based menus that dynamically update based on whether a user is a normal user or an Admin.
   - **Interactive Elements**: Real-time **AJAX** availability checks, dynamic **Swiper.js** sliders, and **SweetAlert2** for elegant user feedback.
 ## 3. User Authentication System
The IIUM Court Booking System implements a secure and robust authentication system using Laravel Jetstream with Livewire. The authentication workflow is handled through multiple Blade view files, each responsible for a specific authentication process.
* ### **Authentication Features**
  1. User Registration
     - Implemented in register.blade.php
     - Collects user information (users and admin) and securely stores credentials
  2. User Login
     - Implemented in login.blade.php
     - Authenticates user and admin using valid email and password
  3. Password Reset
     - Implemented using forgot-password.blade.php and reset-password.blade.php
     - Users receive a reset link vie email
  4. Email verification
     - Implemented in verify-email.blade.php
     - Ensures only verified users can access system features
  5. Password confirmation
     - Implemented in confirm-password.blade.php
     - Adds an extra layer of security for sensitive actions
  6. Two-Factor Authentication
     - Implemented in two-factor-challenge.blade.php
     - Enhances account security by requiring a second authentication factor
    
* ### **Security Measures**
  1. Password Hashing
     - Passwords are hashed using Laravel's built-in hashing mechanism
  2. CSFR Protection
     - All authentications forms include CSFR tokens to prevent request forgery
  3. Session-Based Authentication
     - Secure session handling ensures authorized access
  4. Two-factor authentication
     - Prevents unauthorized access even if credentials are compromised
  5. Email verification
     - Confirms the authencity of user email addresses
  6. Middleware protection
     - Access to protected routes is restricted using authentication middleware
 ## 4. Installation and Setup Instructions
  
* ### **Prerequisites**
  1. PHP ≥ 8.1
  2. Composer
  3. Node.js & NPM
  4. MySQL or MariaDB
  5. Git
  6. Web Server (XAMPP)

  * ### **Step-by-step installation**
  1. Clone the Repository

* git clone [https://github.com/[your-username]/QuickPlate.git/n](https://github.com/h43mi/IIUM-CBS-Booking-Sport-Website.git)
* cd IIUM-CBS-Booking-Sport-Website

  2. Install Dependencies

* composer install
* npm install

3. Environment Configuration

* copy .env.example .env
* php artisan key:generate


4. Configure environment env. file and edit database credentials
* DB_CONNECTION=mysql
* DB_HOST=127.0.0.1
  * DB_PORT=3306
  * DB_DATABASE=webapp
  * DB_USERNAME=root
  * DB_PASSWORD=

5. Create a database
* by using phpMyAdmin, create a database named webapp
   
6. Run Database Migrations
  * Command: php artisan migrate

7. Create Models, Controllers, and Migrations
  * Command:

  * php artisan make:model Booking -m
  * php artisan make:model Court -m
  * php artisan make:model User -m
  * php artisan make:controller BookingController
  * php artisan make:controller ContactController
  * php artisan make:controller Controller
  * php artisan make:controller CourtController

8. Start Development Server
  * bashphp artisan serve
  * npm run dev


 ## 5. Testing and Quality Assurance
The IIUM Court Booking System was tested to ensure functionality, compatibility, and performance.
* ### **Functionality Testing**
1. User registration and login tested with valid and invalid credentials
2. Admin registration and login tested with valid and invalid credentials
3. Court booking process for user tested for:
   - Edit booking
   - Payment for booking
   - Succesfull booking
   - View booking history
4. Contact form was tested for sending and receiving inquiries
5. Admin dashboard was tested for:
   - Add facility
   - Approve and reject booking
   - View pending requests
   - manage bookings where admin can edit bookings, view the user and booking details
* ### **Browser Compatibility**
  1. Google Chrome: Fully supported
  2. Microsoft Edge: Fully supported
  3. Mozilla Firefox: Fully supported
 
* ### **Performance Testing**
  1. Page loading time remains fast due to Laravel's optimized routing and Blade templating.
  2. Database queries are optimized using Eloquent ORM.
  3. Swiper.js and Bootstrap components are lightweight and do not affect performance significantly
  4. Tested under multiple simultaneous users with no major performance degradation
 
* ### **Usability Testing**
  1. Responsive layout tested on dekstop, tablet, and mobile screens.
  2. User interface tested for clarify, readability, and ease of navigation
  3. Error messages and validation feedback tested for enhancing user friendly.
 
* ### **Tools Used for Testing**
  1. Manual testing via browser
##  Challenges Faced and Solutions
During development, we encountered several technical hurdles. Below is a summary of how we resolved them:
### 1. Incomplete Bookings Cluttering the Dashboard
**The Issue:**
Creating database records immediately upon slot selection resulted in "Unpaid" ghost records if users abandoned the process. This cluttered dashboards with invalid data.
**The Solution:**
We implemented a **Session-Based Temporary Storage** mechanism.
- Booking details are saved temporarily in the user's Laravel Session (`session()->put()`).
- Data is only committed to the database (`Booking::create`) *after* the payment receipt is successfully uploaded.
- This ensures only genuine, intent-driven bookings are recorded.
### 2. Image Path Consistency
**The Issue:**
The system handles images from two sources: default "seeded" assets (in `public/assets`) and admin uploads (in `storage/app/public`). Using a single path logic resulted in broken images.
**The Solution:**
We implemented **Conditional Logic in Blade Views**:
- Used `Str::startsWith` to detect the image source.
- If it's a storage path, the system uses the `asset('storage/...')` helper.
- Otherwise, it falls back to `asset('assets/...')`.
- *Note:* We also ran `php artisan storage:link` to ensure symbolic links were correctly configured.
### 3. Real-Time Availability & Overlap Prevention
**The Issue:**
Preventing double bookings without frustrating the user required an immediate feedback loop without page refreshes.
**The Solution:**
We utilized **AJAX Fetch Requests**:
- A JavaScript function triggers a `GET` request to `/bookings/check` when a date is selected.
- The controller returns booked slots (excluding "Rejected" statuses) as JSON.
- The frontend dynamically disables checkboxes for occupied slots, providing immediate visual cues.
### 4. Preserving Data During Admin Updates
**The Issue:**
Editing a booking (e.g., changing time/date) logically required deleting old slots and creating new ones, which inadvertently wiped out metadata like `court_number`.
**The Solution:**
We refined the `updateAdmin` logic:
- Before deletion, the system captures original attributes (e.g., `court_number`, `payment_proof`) into variables.
- These preserved values are re-injected when creating the new slots, maintaining data integrity.
---
##  Future Improvements
While the system is fully functional, the following enhancements are planned for future iterations:
*  Payment Gateway Integration
    * Integrate ToyyibPay, Stripe, or FPX to allow automated status updates (Pending $\to$ Approved) immediately upon payment, removing manual admin verification.
*  Email Notification System
    * Use Laravel's `Mailable` class to send automated confirmations to users upon approval and alerts to admins for new requests.
*  Recurring Booking Feature
    * Add functionality for "Semester Bookings" or "Club Bookings," allowing specific roles to reserve slots (e.g., Every Friday 8 PM) for multiple weeks in one transaction.
*  QR Code Check-in
    * Generate unique QR codes for approved bookings that can be scanned at the facility counter to verify validity instantly.
---
##  Conclusion and Learning Outcomes
### Conclusion
The Conclusion The Court Booking System (IIUM CBS) successfully achieves its primary objective of digitizing the sports facility reservation process. By transitioning from a manual system to a web-based solution, we have eliminated common issues such as double bookings and lost records. The system provides a seamless experience for students to view availability and book courts, while simultaneously empowering administrators with robust tools to manage facilities and oversee revenue. The use of the Laravel MVC framework ensured that the application is secure, scalable, and easy to maintain.
### Learning Outcomes
* Full-Stack Framework Mastery: Gained deep proficiency in Laravel 12, understanding the Model-View-Controller (MVC) architecture, routing, middleware security, and Blade templating.
* Database Management: Learned to design relational databases using MySQL/MariaDB, handling One-to-Many relationships (Users -> Bookings -> Courts) and using Eloquent ORM for efficient data queries.
* Asynchronous Programming: Understood the importance of AJAX for creating responsive user interfaces that interact with the server without requiring full page reloads.
* Authentication & Security: Gained practical experience implementing Laravel Jetstream for secure user authentication, role-based access control (Admin vs. User), and CSRF protection.
