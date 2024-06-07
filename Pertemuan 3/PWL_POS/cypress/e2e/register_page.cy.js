// describe('Login Test', () => {
//   it('Visit Login', () => {
//     cy.visit('/')
//   })
// })

describe('Register Test',function(){
  beforeEach(()=>{
    cy.visit('/')
  })

  // it('Username Valid Password Valid',function(){
  //   cy.get('[name="username"]').type('admin')
  //   cy.get('[name="password"]').type('12345')
  //   cy.get('.btn').click()
  // });

  it('Username Valid Password Valid',function(){
    cy.get(':nth-child(2) > .form-control').type('admin')
    cy.get(':nth-child(3) > .form-control').type('12345')
    cy.get('.btn').click()
  });

  it('Username Tidak Valid Password Valid',function(){
    cy.get(':nth-child(2) > .form-control').type('admin123')
    cy.get(':nth-child(3) > .form-control').type('12345')
    cy.get('.btn').click()
  });

  it('Username Valid Password Tidak Valid',function(){
    cy.get(':nth-child(2) > .form-control').type('admin')
    cy.get(':nth-child(3) > .form-control').type('12345678')
    cy.get('.btn').click()
  });

  it('Username Tidak Valid Password Tidak Valid',function(){
    cy.get(':nth-child(2) > .form-control').type('admin123')
    cy.get(':nth-child(3) > .form-control').type('12345678')
    cy.get('.btn').click()
  });

  it('Username Kosong Password Kosong',function(){
    cy.get(':nth-child(2) > .form-control')
    cy.get(':nth-child(3) > .form-control')
    cy.get('.btn').click()
  });
})
