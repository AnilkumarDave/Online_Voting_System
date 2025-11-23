package com.anildave.onlinevoting.pages;

import lombok.Getter;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;

@Getter
public class VotePage {

    private final WebDriver driver;

    private final By voteOption = By.cssSelector("input[type='radio']");
    private final By submitButton = By.cssSelector("button[type='submit']");
    private final By successMessage = By.cssSelector(".alert-success");

    public VotePage(WebDriver driver) {
        this.driver = driver;
    }

    public void castFirstAvailableVote() {
        driver.findElements(voteOption).get(0).click();
        driver.findElement(submitButton).click();
    }

    public boolean isVoteSubmitted() {
        return !driver.findElements(successMessage).isEmpty();
    }
}
