# NJIT-CS490-PyExamGrader
Online Python exam grading system.

--------------------------------

## Status

**Status:** Inactive :o:

**Purpose of branch:** this branch is just for information  

--------------------------------

## IMPORTANT:

**Message:**  
- This was an **Undergrad Project for [NJIT's](https://www.njit.edu/) [class CS490](https://web.njit.edu/~theo/courses/cs490/cs490syllabus.html)** in which the real purpose of the project was to gain, or taste what working in a software project would be in real life.
- Situations we encounter:
	1. Time Managment
	2. Team Communication
	3. Coordiation. 

- We had to practice 6 of 7 stages of Software Development:
    1. Requirment Analysis :heavy_check_mark:
    2. Design :heavy_check_mark:
    3. Development :heavy_check_mark:
    4. Testing :heavy_check_mark:
    5. Implementation :heavy_check_mark:
    6. Documentation :heavy_check_mark:
    7. Maintenance :x:

--------------------------------

## Application Objective:

Create and developed a system similar to Moodle or Canvas where a student logs in and takes an exam created by a professor. The systme lets the student takes the exam, submit it and show its scores. Professor, as well, has a profile where he logs in and is able to create questions which are deposited in a question database. He then can proceed to create and exam out of the questions in the questions bank and publish the exam for the students to take.

Once the student is done taking the exam, he/she submits the exam then a grading system reviews the answers and grades it according to a set of parameters stablished:

*  **Function name:** function name is written as specified in question estament.
* **Colon symbol:** is present according to Python syntax. If not the system inputs the colon in order for Python script to be able to run.
*  **Test Cases:** the grading system runs test cases against the functions developed by the student and executes them. The passing or failing of the test determines the pass scored of the function being tested and the exman general.
*  **Constraints:** Some specific constrains (FOR, PRINT, WHILE) must be in the function developed by the student. 


### Architecure:

The system uses the  [Modle View Controller (MVC)](https://www.tutorialspoint.com/mvc_framework/mvc_framework_introduction.htm) model.


![System Design](https://github.com/Andres-CS/PyGrader/blob/NJIT-CS490/Images/SystemDesign(1).png?raw=true) 


 **Notes:**

This Repo belongs to the middle section. It is not the entire system. Please continue reading.

The :muscle:main file:muscle: in the middle section, the actual grading systme is **m_StdEXAM_.php**.

Last, given the way the info was passed from the **front** I created a **parsing** file that structures the data for my better use. 

For this project we had 3 front-ends, a single middle and back.
 
:warning::warning::warning::Please note that **we are not positng the API structure** (how data was transmitted across the system) in case any future student  stumples upon this repo and if the project has been re-used for future semesters.:warning::warning::warning:
 
--------------------------------

## Team

Below you will find Names and roles of student with whom this application was developed. 

**Front**
- Chika
- [Moises](https://github.com/Mohdez)
- Rimon

**Middle**
- [Me ](https://github.com/Andres-CS)

**Back**
- [Princewill](https://github.com/PrincewillO)

--------------------------------

**Images:**

You can take a look at how the project looks in the images folder.
