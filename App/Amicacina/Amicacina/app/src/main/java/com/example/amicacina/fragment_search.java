package com.example.amicacina;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Spinner;

public class fragment_search extends Fragment {

    Spinner spnPort, spnGen;
    public fragment_search() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_search, container, false);
        spnPort = (Spinner)view.findViewById(R.id.spnPorte);
        String text = spnPort.getSelectedItem().toString();

        spnGen = (Spinner)view.findViewById(R.id.spnGenero);
        String text2 = spnGen.getSelectedItem().toString();

        return view;
    }
}