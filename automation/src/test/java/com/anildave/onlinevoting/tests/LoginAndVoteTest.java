package com.anildave.onlinevoting.tests;

import com.anildave.onlinevoting.BaseTest;
import com.anildave.onlinevoting.pages.LoginPage;
import com.anildave.onlinevoting.pages.VotePage;
import org.testng.Assert;
import org.testng.annotations.Test;

public class LoginAndVoteTest extends BaseTest {

    @Test
    public void voterCanLoginAndCastVote() {
        LoginPage loginPage = new LoginPage(driver);
        loginPage.open(BASE_URL);

        // Demo credentials – these should match the sample data in the PHP app.
        loginPage.loginAs("voter1", "password123");

        VotePage votePage = new VotePage(driver);
        votePage.castFirstAvailableVote();

        Assert.assertTrue(votePage.isVoteSubmitted(),
                "Expected a success message after casting a vote.");
    }
}
