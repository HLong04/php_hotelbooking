// JavaScript Document

// Tooplate 2148 Bistro Elegance

// https://www.tooplate.com/view/2148-bistro-elegance

// Mobile menu toggle
const menuToggle = document.querySelector('.menu-toggle');
const navLinks = document.querySelector('.nav-links');

menuToggle.addEventListener('click', () => {
   navLinks.classList.toggle('active');
});

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
   anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
         // Remove active class from all nav links
         document.querySelectorAll('.nav-links a').forEach(link => {
            link.classList.remove('active');
         });
         // Add active class to clicked link
         this.classList.add('active');

         target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
         });
      }
      navLinks.classList.remove('active');
   });
});

// Update active nav item on scroll
function updateActiveNavItem() {
   const sections = document.querySelectorAll('section[id]');
   const navLinks = document.querySelectorAll('.nav-links a[href^="#"]');

   let current = '';
   const scrollPosition = window.scrollY + 100;

   sections.forEach(section => {
      const sectionTop = section.offsetTop;
      const sectionHeight = section.offsetHeight;
      if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
         current = section.getAttribute('id');
      }
   });

   navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('href') === `#${current}`) {
         link.classList.add('active');
      }
   });
}

// Generate diagonal elements for entire home area
function createDiagonalGrid() {
   const grid = document.querySelector('.diagonal-grid');
   if (!grid) return;

   // Create 6 solid light grey diagonal blocks in bottom-left corner, moved down and spread out
   const blocks = [{
         width: 80,
         bottom: -400,
         left: -100,
         delay: 0,
         duration: 22
      },
      {
         width: 60,
         bottom: -300,
         left: 100,
         delay: 2,
         duration: 20
      },
      {
         width: 100,
         bottom: -370,
         left: 350,
         delay: 1,
         duration: 24
      },
      {
         width: 70,
         bottom: -230,
         left: 200,
         delay: 1.5,
         duration: 21
      },
      {
         width: 90,
         bottom: -170,
         left: 500,
         delay: 0.5,
         duration: 23
      },
      {
         width: 50,
         bottom: -270,
         left: 400,
         delay: 3,
         duration: 25
      }
   ];

   blocks.forEach(block => {
      const element = document.createElement('div');
      element.className = 'soft-block';
      element.style.width = `${block.width}px`;
      element.style.bottom = `${block.bottom}px`;
      element.style.left = `${block.left}px`;
      element.style.animationDelay = `${block.delay}s`;
      element.style.animationDuration = `${block.duration}s`;
      grid.appendChild(element);
   });
}

// Create static decoration blocks
function createStaticDecoration() {
   const decoration = document.querySelector('.static-decoration');
   if (!decoration) return;

   // 9 blocks for top-right corner decoration (6 outline, 3 filled) with sizes from 40px to 120px
   const staticBlocks = [{
         size: 85,
         top: '20px',
         right: '30px',
         outline: true
      },
      {
         size: 120,
         top: '80px',
         right: '120px',
         outline: false
      },
      {
         size: 100,
         top: '140px',
         right: '50px',
         outline: true
      },
      {
         size: 40,
         top: '50px',
         right: '180px',
         outline: true
      },
      {
         size: 95,
         top: '200px',
         right: '150px',
         outline: false
      },
      {
         size: 60,
         top: '100px',
         right: '280px',
         outline: true
      },
      {
         size: 75,
         top: '180px',
         right: '220px',
         outline: true
      },
      {
         size: 50,
         top: '300px',
         right: '180px',
         outline: true
      },
      {
         size: 90,
         top: '60px',
         right: '320px',
         outline: false
      }
   ];

   staticBlocks.forEach(block => {
      const element = document.createElement('div');
      element.className = block.outline ? 'static-block-outline' : 'static-block';
      element.style.width = `${block.size}px`;
      element.style.height = `${block.size}px`;
      element.style.top = block.top;
      element.style.right = block.right;
      decoration.appendChild(element);
   });
}

// Create red decoration blocks for bottom right
function createBottomRightDecoration() {
   const decoration = document.querySelector('.bottom-right-decoration');
   if (!decoration) return;

   // 6 blocks for bottom-right corner (4 filled red + 2 outline)
   const redBlocks = [{
         size: 65,
         bottom: '20px',
         right: '40px',
         outline: false
      },
      {
         size: 45,
         bottom: '60px',
         right: '120px',
         outline: false
      },
      {
         size: 85,
         bottom: '120px',
         right: '60px',
         outline: false
      },
      {
         size: 35,
         bottom: '100px',
         right: '150px',
         outline: false
      },
      {
         size: 55,
         bottom: '40px',
         right: '200px',
         outline: true
      },
      {
         size: 70,
         bottom: '160px',
         right: '140px',
         outline: true
      }
   ];

   redBlocks.forEach(block => {
      const element = document.createElement('div');
      element.className = block.outline ? 'red-block-outline' : 'red-block';
      element.style.width = `${block.size}px`;
      element.style.height = `${block.size}px`;
      element.style.bottom = block.bottom;
      element.style.right = block.right;
      decoration.appendChild(element);
   });
}

// Ingredients data
const ingredientsData = {
   'truffle-risotto': {
      title: 'Truffle Risotto',
      ingredients: [{
            name: 'Arborio Rice',
            allergen: false
         },
         {
            name: 'Black Truffle',
            allergen: false
         },
         {
            name: 'Parmesan Cheese',
            allergen: true
         },
         {
            name: 'Vegetable Stock',
            allergen: false
         },
         {
            name: 'White Wine',
            allergen: false
         },
         {
            name: 'Butter',
            allergen: true
         },
         {
            name: 'Fresh Herbs',
            allergen: false
         },
         {
            name: 'Shallots',
            allergen: false
         }
      ]
   },
   'grilled-salmon': {
      title: 'Grilled Salmon',
      ingredients: [{
            name: 'Atlantic Salmon',
            allergen: true
         },
         {
            name: 'Lemon',
            allergen: false
         },
         {
            name: 'Butter',
            allergen: true
         },
         {
            name: 'Seasonal Vegetables',
            allergen: false
         },
         {
            name: 'Olive Oil',
            allergen: false
         },
         {
            name: 'Fresh Dill',
            allergen: false
         },
         {
            name: 'Sea Salt',
            allergen: false
         },
         {
            name: 'Black Pepper',
            allergen: false
         }
      ]
   },
   'beef-wellington': {
      title: 'Beef Wellington',
      ingredients: [{
            name: 'Beef Tenderloin',
            allergen: false
         },
         {
            name: 'Puff Pastry',
            allergen: true
         },
         {
            name: 'Mushroom Duxelles',
            allergen: false
         },
         {
            name: 'Prosciutto',
            allergen: false
         },
         {
            name: 'Egg Wash',
            allergen: true
         },
         {
            name: 'Fresh Thyme',
            allergen: false
         },
         {
            name: 'Dijon Mustard',
            allergen: false
         },
         {
            name: 'Red Wine Jus',
            allergen: false
         }
      ]
   },
   'lobster-thermidor': {
      title: 'Lobster Thermidor',
      ingredients: [{
            name: 'Fresh Lobster',
            allergen: true
         },
         {
            name: 'Cognac',
            allergen: false
         },
         {
            name: 'Heavy Cream',
            allergen: true
         },
         {
            name: 'Gruyere Cheese',
            allergen: true
         },
         {
            name: 'Butter',
            allergen: true
         },
         {
            name: 'Egg Yolks',
            allergen: true
         },
         {
            name: 'Fresh Tarragon',
            allergen: false
         },
         {
            name: 'White Pepper',
            allergen: false
         }
      ]
   },
   'duck-confit': {
      title: 'Duck Confit',
      ingredients: [{
            name: 'Duck Leg',
            allergen: false
         },
         {
            name: 'Duck Fat',
            allergen: false
         },
         {
            name: 'Garlic Potatoes',
            allergen: false
         },
         {
            name: 'Fresh Cherries',
            allergen: false
         },
         {
            name: 'Red Wine Vinegar',
            allergen: false
         },
         {
            name: 'Fresh Thyme',
            allergen: false
         },
         {
            name: 'Bay Leaves',
            allergen: false
         },
         {
            name: 'Coarse Salt',
            allergen: false
         }
      ]
   },
   'chocolate-souffle': {
      title: 'Chocolate Soufflé',
      ingredients: [{
            name: 'Dark Chocolate',
            allergen: false
         },
         {
            name: 'Eggs',
            allergen: true
         },
         {
            name: 'Sugar',
            allergen: false
         },
         {
            name: 'Butter',
            allergen: true
         },
         {
            name: 'Vanilla Ice Cream',
            allergen: true
         },
         {
            name: 'Mixed Berries',
            allergen: false
         },
         {
            name: 'Heavy Cream',
            allergen: true
         },
         {
            name: 'Vanilla Extract',
            allergen: false
         }
      ]
   }
};

// Show ingredients modal
function showIngredients(dishId) {
   const modal = document.getElementById('ingredientsModal');
   const title = document.getElementById('modalTitle');
   const list = document.getElementById('ingredientsList');

   const dish = ingredientsData[dishId];
   if (dish) {
      title.textContent = dish.title;
      list.innerHTML = '';

      dish.ingredients.forEach(ingredient => {
         const li = document.createElement('li');
         li.innerHTML = `
                        <span>${ingredient.name}</span>
                        ${ingredient.allergen ? '<span class="allergen">Allergen</span>' : ''}
                    `;
         list.appendChild(li);
      });

      modal.style.display = 'block';
   }
}

// Close modal
function closeModal() {
   document.getElementById('ingredientsModal').style.display = 'none';
}

// Close modal when clicking outside
window.addEventListener('click', (e) => {
   const modal = document.getElementById('ingredientsModal');
   if (e.target === modal) {
      closeModal();
   }
});

// Handle reservation form
function handleReservation(e) {
   e.preventDefault();

   const formData = new FormData(e.target);
   const reservation = {
      name: formData.get('name'),
      email: formData.get('email'),
      phone: formData.get('phone'),
      date: formData.get('date'),
      time: formData.get('time'),
      guests: formData.get('guests'),
      special: formData.get('special')
   };

   // Simulate form submission
   alert(`Thank you, ${reservation.name}! Your reservation for ${reservation.guests} guests on ${reservation.date} at ${reservation.time} has been confirmed. We will send a confirmation email to ${reservation.email}.`);

   // Reset form
   e.target.reset();
}

// Navbar scroll effect
window.addEventListener('scroll', () => {
   const nav = document.querySelector('nav');
   if (window.scrollY > 100) {
      nav.style.background = 'rgba(255, 255, 255, 0.98)';
      nav.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
   } else {
      nav.style.background = 'rgba(255, 255, 255, 0.95)';
      nav.style.boxShadow = 'none';
   }

   // Update active nav item
   updateActiveNavItem();
});

// Initialize all elements when page loads
document.addEventListener('DOMContentLoaded', () => {
   // Set minimum date to today
   const dateInput = document.getElementById('date');
   if (dateInput) {
      const today = new Date().toISOString().split('T')[0];
      dateInput.setAttribute('min', today);
   }

   // Create all decorative elements
   createDiagonalGrid();
   createStaticDecoration();
   createBottomRightDecoration();

   // Set initial active nav item to Home
   const homeLink = document.querySelector('.nav-links a[href="#home"]');
   if (homeLink) {
      homeLink.classList.add('active');
   }
});