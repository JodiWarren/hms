Feature: Registration
	To cope with a growing userbase
	It should be possible to automate most of the sign-up procedure
	Through HMS

Scenario: Register with new e-mail
	Given I am in the hackspace
	And I go to the homepage
	When I click the register link on the home page
	And I am on the member register page
	And I fill in the register form
	And I submit the register form
	Then I am on the homepage
	And I should see the registration successful message
	And the following e-mails are sent
		| emailType                     |
		| new_member_welcome_email      |
		| new_member_member_admin_email |

Scenario: Register when already a prospective member
	Given I am in the hackspace
	And I go to the homepage
	When I click the register link on the home page
	And I am on the member register page
	And I fill in the register form with an e-mail that belongs to a prospective member
	And I submit the register form
	Then I am on the homepage
	And I should see the registration successful message
	And the following e-mails are sent
		| emailType                     |
		| new_member_welcome_email      |

Scenario: Register when already a waiting for contact details member
	Given I am in the hackspace
	And I go to the homepage
	When I click the register link on the home page
	And I am on the member register page
	And I fill in the register form with an e-mail that belongs to a waiting for contact details member
	And I submit the register form
	Then I am on the member login page
	And no e-mails are sent
	And I should see the user already registered message

Scenario: Register when already a waiting for contact detail approval member
	Given I am in the hackspace
	And I go to the homepage
	When I click the register link on the home page
	And I am on the member register page
	And I fill in the register form with an e-mail that belongs to a waiting for contact detail approval member
	And I submit the register form
	Then I am on the member login page
	And no e-mails are sent
	And I should see the user already registered message

Scenario: Register when already a waiting for payment member
	Given I am in the hackspace
	And I go to the homepage
	When I click the register link on the home page
	And I am on the member register page
	And I fill in the register form with an e-mail that belongs to a waiting for payment member
	And I submit the register form
	Then I am on the member login page
	And no e-mails are sent
	And I should see the user already registered message

Scenario: Register when already a current member
	Given I am in the hackspace
	And I go to the homepage
	When I click the register link on the home page
	And I am on the member register page
	And I fill in the register form with an e-mail that belongs to a current member
	And I submit the register form
	Then I am on the member login page
	And no e-mails are sent
	And I should see the user already registered message

Scenario: Register when already an ex member
	Given I am in the hackspace
	And I go to the homepage
	When I click the register link on the home page
	And I am on the member register page
	And I fill in the register form with an e-mail that belongs to an ex member
	And I submit the register form
	Then I am on the member login page
	And no e-mails are sent
	And I should see the user already registered message
