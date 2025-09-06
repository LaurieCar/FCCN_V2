describe('Connexion admin - back-office', () => {

    it('doit se connecter avec succès', () => {
        cy.visit('https://127.0.0.1:8000/login');

        // récupère les identifiants de connexion 
        cy.get('input[name="email"]').type(Cypress.env('ADMIN_EMAIL'));
        cy.get('input[name="password"]').type(Cypress.env('ADMIN_PASSWORD'), {log:false});

        cy.get('form').submit();

        cy.url().should('include', '/admin');
        cy.get('span.logo-custom')
            .should('exist')
            .and('be.visible')
            .and('contain.text', 'FCCN V2');
    })

})
