describe('Connexion admin - back-office', () => {

    it('doit se connecter avec succès', () => {
        cy.visit('http://127.0.0.1:8001/admin');

        // récupère les identifiants de connexion 
        cy.get('input[name="email"]').type('admin1@fccn.com');
        cy.get('input[name="password"]').type('Azerty77'), {log:false};

        cy.get('form').submit();

        cy.url().should('include', '/admin');
        cy.get('span.logo-custom')
            .should('exist')
            .and('be.visible')
            .and('contain.text', 'FCCN V2');
    })

})
