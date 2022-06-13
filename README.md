# <p align="center">School Pack</p>

## How to Install

### Install this project using the steps below

<br>

-   **Clone the project**

```bash
git clone https://github.com/BitsandNibble/school-pack.git
```

-   **Run `composer install` to install the vendor files**

```bash
composer install
```

-   **Run `npm install`**

```bash
npm install
```

-   **Run `npm run dev` to publish the assets**

```bash
npm run dev
```

-   **Note that the .env file is available so no need to use .env.example**
-   **A scss file exits in `resources/scss/app.scss`. Add your custom css here and run**

```bash
npm run dev
```

or

```bash
npm run watch
```

to publish your changes to `public/assets/css/custom.css`

## TODO:

### General

-   [x] Create a 'Comments Bank' so principal & teachers can either type or select comments
-   [x] Feature to insert comments in the 'Comments Bank'
-   [x] Rename 'comments' to 'comments_bank'
-   [ ] Fetch student's past results using the year, and student_id (from mark/exam_records table)
-   [ ] Seperate 'manage payment' into General and Individual Comnoonent
-   [ ] Setup Wizard to insert all the necessary data before using the app
-   [ ] Disable button when submitting a form or updating a form
-   [ ] Print profile pages (Still thinking)
-   [ ] Add csv icon to import or export data on various pages
-   [ ] Probably Use select2 picker for select boxes
-   [ ] Customise tables: Add CSV, PDF, PRINT buttons & handle functionality personally
-   [ ] Use <datalist></datalist> to recommend a list of subjects from a subject bank, when creating a new subject
-   [ ] Users should be able to update/change password
-   [ ] Figure out a way to generate school_id for admin/principal
-   [ ] Automatically register all junior school students to specified subjects
-   [ ] Multi delete with checkbox
-   [ ] Use another approach to generate staff_id, student_id
-   [ ] Find another name for TabulationSheet
-   [ ] Crop school image/logo before upload
-   [ ] Automatic promotion when term comes to an and or something of sort. (Could be done by a trigger) (Admin sets the criteria for promotion & at the end of the session, button appears and onclick, students that meet the crtieria are promoted) (Might have to create another table for this)
-   [ ] On app load/sign in, do the following:
    -   [ ] Check if exam is locked
    -   [ ] Get current session, and lock all other sessions

### Principal/Admin

-   [ ] Perform Bulk Actions:
    -   [ ] Print individual student result
    -   [ ] Print All students result (Probably by class)
    -   [ ] Export as CSV | PDF
-   [ ] When creating new class, add multiple checkbox to select predefined(static) sections (A,B,C,RED,BLUE,SILVER,GOLD,etc)
-   [ ] Show only subjects that haven't been assigned to a teacher when assigning subjects to teachers
-   [ ] Validation: when creating sections, prevent duplicate section names for the same class
-   [ ] Create skills bank to easily be used in the marksheet
-   [ ] Work on Students > Manage Promotions [Reset Prompotions]
-   [ ] Show graduated students

### Students

-   [ ] What data should be shown on profile page

### Bugs

-   [ ] When selecting/inserting skills on result page
-   [ ] When inserting scores (very slow due to multiple request to the 'grades' table)
-   [ ] Optimize db query on debtors page
-   [ ] When adding multiple subjects
    -   [ ] Graphical bug
    -   [ ] Error on submit
-   [ ] Fix pagination(resetPage()) on delete. (i.e. If there are only 11 items and you navigate to the second page which only shows the last (11th) item, when you delete the 11th item, the page should reset and show only 10 items. But it just renders a blank table, until you refresh)
-   [ ] Search querying results from other parts of the db (Student Livewire Component)
-   [ ] Unable to unregister students from a subject
-   [ ] Validation not kicking in when registering subjects for students because it's auto-fetching the records from the db
-   [ ] Term date not showing in settings
-   [ ] When updating image, other fields aren't updated until second click
-   [ ] Only assigned form teacher can print out tabulation sheet
-   [ ] Issues when trying to edit state & LGA in user profiles
-   [ ] Promote button promotes all students, etc
-   [ ] When you promote a student, it seems his grade for his previous class disappears
-   [ ] When you edit a payment i.e. when you choose a payment class froom "all classes" to "SSS1, should resulrs containing "all classes be deleted"?
-   [ ] Insert specif values to rese() on livewire compoent when usiig $this->cancel() so that when it's done bulk deleting, and you cancel, it still retains the selected values
-   [ ] Remove wire:defer and button from pages/components with "select tag" on top, and render when the last "select tag" is populated

### Future Features

-   [ ] Create timetble dynamically
-   [ ] Online payemnt of fees
-   [ ] Use SoftDeletes on all models
-   [ ] Class/subject timetable generator
-   [ ] Exam timetable generator
-   [ ] Exam hall generator
-   [ ] Attendance marker/calculator
-   [ ] Online storage of files
-   [ ] Prefectship roles

### References

-   [Academico](https://academico.thomasdebay.com)
-   Laravel Backpack
-   flatmap()
-   ploi.io
-   multi-domain multi-database tenancy
-   customers get subdomains by default, can edit after regisetering
-   complete sign-up flow for multi-tenancy
