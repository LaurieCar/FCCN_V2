describe("Admin - Création d'une actualité ", () => {
    
    const title = "News test Cypress";
    const content = 'Contenu de test Cypress';
    const slug = 'news-test-cypress';
    const createdAt = new Date().toISOString().slice(0, 10);

    // avant la création de la nouvelle actu, l'admin doit être connecté
    beforeEach(() => {
        cy.loginAsAdmin() ; // récupération de la commande custom de connexion
    });

    it('doit créer une nouvelle actualité', () => {
        // Accéder à la sections News
        cy.contains('a, button', 'News').should('be.visible').click();
        // Ajouter une news
        cy.contains('a, button', 'Add News').should('be.visible').click();
        // remplir le formulaire
        cy.get('input[name$="News[title]"]')
            .should('be.visible').clear().type(title)
        cy.get('textarea[name$="News[content]"]')
            .should('be.visible').clear().type(content)
        cy.get('input[name$="News[slug]"]').
            should('be.visible').clear().type(slug)
        cy.get('input[name$="News[created_at]"]')
            .should('be.visible').clear().type(createdAt)
        cy.get('input[type="checkbox"][name$="News[is_published]"]')
            .should('exist').check()
        cy.get('#News_category-ts-control')
            .should('be.visible').click()
        cy.get('#News_category-ts-dropdown .option')
            .first().click()
        // Soumission du formulaire
        cy.get('button[value="saveAndReturn"]')
            .should('be.visible').click()
        // Vérification du titre dans la liste des actualités
        cy.contains(title).should('be.visible')

    });


});