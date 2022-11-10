package com.example.amicacina;

public class GridModel {

    // Criando variáveis para armazenar os dados do pet
    private String pet_id, pet_name, pet_raca, pet_nasc, pet_idad, pet_stat, pet_gene, pet_port, pet_comp, imgid;

    // Instanciando as variáveis na ordem que deve ser preenchida, serve como um modelo onde todos os dados são incluidos
    // na exata ordem, como em um vetor
    public GridModel(String pet_id, String pet_name, String pet_raca, String pet_nasc, String pet_idad, String pet_stat,
                     String pet_gene, String pet_port, String pet_comp, String imgid) {
        this.pet_id = pet_id;
        this.pet_name = pet_name;
        this.pet_raca = pet_raca;
        this.pet_nasc = pet_nasc;
        this.pet_idad = pet_idad;
        this.pet_stat = pet_stat;
        this.pet_gene = pet_gene;
        this.pet_port = pet_port;
        this.pet_comp = pet_comp;
        this.imgid = imgid;
    }

    // Métodos getters e setters, utilizado para proteger os dados
    public String getpet_id() {
        return pet_id;
    }

    public void setpet_id(String id) {
        this.pet_id = id;
    }

    public String getpet_name() {
        return pet_name;
    }

    public void setpet_name(String pet_name) {
        this.pet_name = pet_name;
    }

    public String getImgid() {
        return imgid;
    }

    public void setImgid(String imgid) {
        this.imgid = imgid;
    }

    public String getPet_raca() {
        return pet_raca;
    }

    public void setPet_raca(String pet_raca) {
        this.pet_raca = pet_raca;
    }

    public String getPet_nasc() {
        return pet_nasc;
    }

    public void setPet_nasc(String pet_nasc) {
        this.pet_nasc = pet_nasc;
    }

    public String getPet_idad() {
        return pet_idad;
    }

    public void setPet_idad(String pet_idad) {
        this.pet_idad = pet_idad;
    }

    public String getPet_stat() {
        return pet_stat;
    }

    public void setPet_stat(String pet_stat) {
        this.pet_stat = pet_stat;
    }

    public String getPet_gene() {
        return pet_gene;
    }

    public void setPet_gene(String pet_gene) {
        this.pet_gene = pet_gene;
    }

    public String getPet_port() {
        return pet_port;
    }

    public void setPet_port(String pet_port) {
        this.pet_port = pet_port;
    }

    public String getPet_comp() {
        return pet_comp;
    }

    public void setPet_comp(String pet_comp) {
        this.pet_comp = pet_comp;
    }


}

