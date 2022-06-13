package com.example.amicacina;

public class GridModel {

    // string pet_name for storing pet_name
    // and imgid for storing image id.
    private String pet_name;
    private int imgid;

    public GridModel(String pet_name, int imgid) {
        this.pet_name = pet_name;
        this.imgid = imgid;
    }

    public String getpet_name() {
        return pet_name;
    }

    public void setpet_name(String pet_name) {
        this.pet_name = pet_name;
    }

    public int getImgid() {
        return imgid;
    }

    public void setImgid(int imgid) {
        this.imgid = imgid;
    }
}
